<?php
namespace Concrete\Package\MigrationTool\Controller\SinglePage\Dashboard\System\Migration;

use Concrete\Core\File\Importer;
use Concrete\Core\File\Set\Set;
use Concrete\Core\Foundation\Processor\Processor;
use Concrete\Package\MigrationTool\Page\Controller\DashboardPageController;
use Doctrine\Common\Collections\ArrayCollection;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\TargetItemList;
use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\Page\TreePageJsonFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Processor\Target;
use PortlandLabs\Concrete5\MigrationTool\Batch\Processor\Task\MapContentTypesTask;
use PortlandLabs\Concrete5\MigrationTool\Batch\Processor\Task\NormalizePagePathsTask;
use PortlandLabs\Concrete5\MigrationTool\Batch\Processor\Task\TransformContentTypesTask;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Publisher;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Importer\FileParser as Parser;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BatchTargetItem;
use Symfony\Component\HttpFoundation\JsonResponse;

class Import extends DashboardPageController
{
    public function add_batch()
    {
        if (!$this->token->validate('add_batch')) {
            $this->error->add($this->token->getErrorMessage());
        }
        if (!$this->error->has()) {
            $batch = new Batch();
            $batch->setNotes($this->request->request->get('notes'));
            $this->entityManager->persist($batch);
            $this->entityManager->flush();
            $this->flash('success', t('Batch added successfully.'));
            $this->redirect('/dashboard/system/migration/import', 'view_batch', $batch->getId());
        }
        $this->view();
    }

    public function delete_batch()
    {
        if (!$this->token->validate('delete_batch')) {
            $this->error->add($this->token->getErrorMessage());
        }
        if (!$this->error->has()) {
            $r = $this->entityManager->getRepository('\PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch');
            $batch = $r->findOneById($this->request->request->get('id'));
            if (is_object($batch)) {
                foreach ($batch->getObjectCollections() as $collection) {
                    $this->entityManager->remove($collection);
                }
                $batch->setObjectCollections(new ArrayCollection());
                foreach ($batch->getTargetItems() as $targetItem) {
                    $targetItem->setBatch(null);
                    $this->entityManager->remove($targetItem);
                }
                $this->entityManager->flush();
                $this->entityManager->remove($batch);
                $this->entityManager->flush();
                $this->flash('success', t('Batch removed successfully.'));
                $this->redirect('/dashboard/system/migration');
            }
        }
        $this->view();
    }

    protected function clearContent($batch)
    {
        foreach ($batch->getObjectCollections() as $collection) {
            $this->entityManager->remove($collection);
        }
        $batch->setObjectCollections(new ArrayCollection());
        foreach ($batch->getTargetItems() as $targetItem) {
            $targetItem->setBatch(null);
            $this->entityManager->remove($targetItem);
        }
        $this->entityManager->flush();
    }

    public function clear_batch()
    {
        if (!$this->token->validate('clear_batch')) {
            $this->error->add($this->token->getErrorMessage());
        }
        if (!$this->error->has()) {
            $r = $this->entityManager->getRepository('\PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch');
            $batch = $r->findOneById($this->request->request->get('id'));
            if (is_object($batch)) {
                $this->clearContent($batch);
                $this->flash('success', t('Batch cleared successfully.'));
                $this->redirect('/dashboard/system/migration/import', 'view_batch', $batch->getId());
            }
        }
        $this->view();
    }

    public function delete_files()
    {
        if (!$this->token->validate('delete_files')) {
            $this->error->add($this->token->getErrorMessage());
        }
        if (!$this->error->has()) {
            $r = $this->entityManager->getRepository('\PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch');
            $batch = $r->findOneById($this->request->request->get('id'));
            if (is_object($batch)) {
                foreach ($batch->getFiles() as $f) {
                    $fp = new \Permissions($f);
                    if ($fp->canDeleteFile()) {
                        $f->delete();
                    }
                }
                $fs = $batch->getFileSet();
                if (is_object($fs)) {
                    $fsp = new \Permissions($fs);
                    if ($fsp->canDeleteFileSet()) {
                        $fs->delete();
                    }
                }
                $this->flash('success', t('Batch files deleted successfully.'));
                $this->redirect('/dashboard/system/migration/import', 'batch_files', $batch->getId());
            }
        }
        $this->view();
    }

    public function add_content_to_batch()
    {
        if (!$this->token->validate('add_content_to_batch')) {
            $this->error->add($this->token->getErrorMessage());
        }

        $importer = \Core::make('migration/manager/importer/parser')->driver($this->request->request('format'));

        if (!is_uploaded_file($_FILES['file']['tmp_name'])) {
            $this->error->add(t('Invalid XML file.'));
        } else {
            $importer->validateUploadedFile($_FILES['file'], $this->error);
        }

        $r = $this->entityManager->getRepository('\PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch');
        $batch = $r->findOneById($this->request->request->get('id'));
        if (!is_object($batch)) {
            $this->error->add(t('Invalid batch.'));
        }

        if (!$this->error->has()) {
            if ($this->request->request->get('importMethod') == 'replace') {
                $this->clearContent($batch);
            }

            foreach ($importer->getContentObjectCollections($_FILES['file']['tmp_name']) as $collection) {
                $batch->getObjectCollections()->add($collection);
            }

            $this->entityManager->flush();

            return new JsonResponse($batch);

        } else {
            return $this->app->make('helper/ajax')->sendError($this->error);
        }
    }

    public function run_batch_content_tasks()
    {
        if (!$this->token->validate('run_batch_content_tasks')) {
            $this->error->add($this->token->getErrorMessage());
        }
        $r = $this->entityManager->getRepository('\PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch');
        $batch = $r->findOneById($this->request->request->get('id'));
        if (!is_object($batch)) {
            $this->error->add(t('Invalid batch.'));
        }
        if (!$this->error->has()) {
            $target = new Target($batch);
            $processor = new Processor($target);
            $processor->registerTask(new NormalizePagePathsTask());
            $processor->registerTask(new MapContentTypesTask());
            $processor->process();

            $this->entityManager->flush();

            $processor = new Processor($target);
            $processor->registerTask(new TransformContentTypesTask());
            $processor->process();

            $this->entityManager->persist($batch);
            $this->entityManager->flush();
            return new JsonResponse($batch);
        }
        $this->view();
    }
    public function create_content_from_batch()
    {
        if (!$this->token->validate('create_content_from_batch')) {
            $this->error->add($this->token->getErrorMessage());
        }
        if (!$this->error->has()) {
            $r = $this->entityManager->getRepository('\PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch');
            $batch = $r->findOneById($this->request->request->get('id'));
            if (is_object($batch)) {
                // Create a new
                $publisher = new Publisher($batch);
                $publisher->publish();
                $this->flash('success', t('Batch drafts published successfully.'));
                $this->redirect('/dashboard/system/migration/import', 'view_batch', $batch->getId());
            }
        }
        $this->view();
    }

    public function view()
    {
        $r = $this->entityManager->getRepository('\PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch');
        $batches = $r->findAll(array(), array('date' => 'desc'));
        $this->set('batches', $batches);
        $this->set('batchEmptyMessage', t('You have not created any import batches. Create a batch and add content records to it.'));
        $this->render('/dashboard/system/migration/view_batches');
    }

    public function view_batch($id = null)
    {
        $this->requireAsset('migration/view-batch');
        $this->requireAsset('core/app/editable-fields');
        $this->requireAsset('jquery/fileupload');
        $r = $this->entityManager->getRepository('\PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch');
        $batch = $r->findOneById($id);
        if (is_object($batch)) {
            $formats = array();
            $drivers = \Core::make('migration/manager/importer/parser')->getDrivers();
            foreach ($drivers as $driver) {
                $formats[$driver->getDriver()] = $driver->getName();
            }
            $this->set('batch', $batch);
            $this->set('pageTitle', t('Import Batch'));
            $this->set('mappers', \Core::make('migration/manager/mapping'));
            $this->set('formats', $formats);
            $this->render('/dashboard/system/migration/view_batch');
        } else {
            $this->view();
        }
    }

    public function batch_files($id = null)
    {
        $this->requireAsset('core/file-manager');
        $r = $this->entityManager->getRepository('\PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch');
        $batch = $r->findOneById($id);
        if (is_object($batch)) {
            $this->set('files', $batch->getFiles());
            $this->set('batch', $batch);
            $this->set('pageTitle', t('Files in Batch'));
            $this->render('/dashboard/system/migration/batch_files');
        } else {
            $this->view();
        }
    }

    public function upload_files()
    {
        $files = array();
        if ($this->token->validate('upload_files')) {
            $r = $this->entityManager->getRepository('\PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch');
            $batch = $r->findOneById($this->request->request('id'));
            if (is_object($batch)) {
                $cf = \Core::make('helper/file');
                $fp = \FilePermissions::getGlobal();
                if (isset($_FILES['file']) && (is_uploaded_file($_FILES['file']['tmp_name']))) {
                    if (!$fp->canAddFileType($cf->getExtension($_FILES['file']['name']))) {
                        throw new \Exception(Importer::getErrorMessage(Importer::E_FILE_INVALID_EXTENSION));
                    } else {
                        $ih = new Importer();
                        $response = $ih->import($_FILES['file']['tmp_name'], $_FILES['file']['name']);
                        if (!($response instanceof \Concrete\Core\File\Version)) {
                            throw new \Exception(Importer::getErrorMessage($response));
                        } else {
                            $file = $response->getFile();
                            $fs = Set::getByName($batch->getID());
                            if (!is_object($fs)) {
                                $fs = Set::createAndGetSet($batch->getID(), Set::TYPE_PRIVATE);
                            }
                            $fs->addFileToSet($file);
                            $files[] = $file;
                        }
                    }
                }
            }
        }

        $this->flash('success', t('File(s) uploaded successfully'));
        $r = new \Concrete\Core\File\EditResponse();
        $r->setFiles($files);
        $r->outputJSON();
    }

    public function find_and_replace($id = null)
    {
        $this->view_batch($id);
        $this->set('pageTitle', t('Find and Replace'));
        $this->render('/dashboard/system/migration/find_and_replace');
    }

    public function save_mapping()
    {
        if (!$this->token->validate('save_mapping')) {
            $this->error->add($this->token->getErrorMessage());
        }

        $r = $this->entityManager->getRepository('\PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch');
        $batch = $r->findOneById($this->request->request->get('id'));
        if (!is_object($batch)) {
            $this->error->add(t('Invalid batch.'));
        }

        $mappers = \Core::make('migration/manager/mapping');
        $mapper = $mappers->driver($this->request->request->get('mapper'));
        if (!is_object($mapper)) {
            $this->error->add(t('Invalid mapping type.'));
        }

        if (!$this->error->has()) {
            // First, delete all target items for this particular type, since we're going to re-map
            // them in the post below.
            $r = $this->entityManager->getRepository('\PortlandLabs\Concrete5\MigrationTool\Entity\Import\BatchTargetItem');
            $items = $r->findBy(array(
                'batch' => $batch,
            ));
            foreach ($items as $item) {
                if ($item->getTargetItem()->getItemType() == $mapper->getHandle()) {
                    $this->entityManager->remove($item);
                }
            }
            $this->entityManager->flush();

            $items = $mapper->getItems($batch);
            $post = $this->request->request->get('targetItem');
            $targetItemList = new TargetItemList($batch, $mapper);

            foreach ($items as $item) {
                $value = $post[$item->getIdentifier()];
                $targetItem = $targetItemList->getTargetItem($value);
                $targetItem->setSourceItemIdentifier($item->getIdentifier());

                $batchTargetItem = new BatchTargetItem();
                $batchTargetItem->setBatch($batch);
                $batchTargetItem->setTargetItem($targetItem);
                $batch->target_items->add($batchTargetItem);
                $this->entityManager->persist($batchTargetItem);
            }

            $this->entityManager->flush();

            $target = new Target($batch);
            $processor = new Processor($target);
            $processor->registerTask(new TransformContentTypesTask());
            $processor->process();

            $this->entityManager->flush();

            $this->flash('message', t('Batch mappings updated.'));
            $this->redirect('/dashboard/system/migration/import', 'view_batch', $batch->getId());
        }
    }

    public function validate_batch()
    {
        session_write_close();
        if (!$this->token->validate('validate_batch')) {
            $this->error->add($this->token->getErrorMessage());
        }
        if (!$this->error->has()) {
            $r = $this->entityManager->getRepository('\PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch');
            $batch = $r->findOneById($this->request->request->get('id'));
            if (is_object($batch)) {
                $validator = \Core::make('migration/batch/validator');
                $messages = $validator->validate($batch);
                $formatter = $validator->getFormatter($messages);
                $data['alertclass'] = $formatter->getAlertClass();
                $data['message'] = $formatter->getCreateStatusMessage();
                $messageObjects = array();
                foreach (array_unique($messages->toArray()) as $message) {
                    $messageObjects[] = $message;
                }
                $data['messages'] = $messageObjects;

                return new JsonResponse($data);
            }
        }
    }

    public function load_batch_collection()
    {
        session_write_close();
        $r = $this->entityManager->getRepository('\PortlandLabs\Concrete5\MigrationTool\Entity\Import\ObjectCollection');
        $collection = $r->findOneById($this->request->get('id'));
        if (is_object($collection)) {
            $formatter = $collection->getTreeFormatter();

            return new JsonResponse($formatter);
        }
    }

    public function load_batch_page_data()
    {
        session_write_close();
        $r = $this->entityManager->getRepository('\PortlandLabs\Concrete5\MigrationTool\Entity\Import\Page');
        $page = $r->findOneById($this->request->get('id'));
        if (is_object($page)) {
            $formatter = new TreePageJsonFormatter($page);

            return new JsonResponse($formatter);
        }
    }

    public function update_page_path()
    {
        session_write_close();
        $r = $this->entityManager->getRepository('\PortlandLabs\Concrete5\MigrationTool\Entity\Import\Page');
        $page = $r->findOneById($this->request->get('pk'));
        if (is_object($page)) {
            $page->setBatchPath($this->request->request('value'));
            $this->entityManager->persist($page);
            $this->entityManager->flush();

            return new JsonResponse($page);
        }
    }

    public function map_content($id = null, $type = null)
    {
        $r = $this->entityManager->getRepository('\PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch');
        $batch = $r->findOneById($id);
        $mappers = \Core::make('migration/manager/mapping');
        $mapper = $mappers->driver($type);
        if (is_object($batch) && is_object($mapper)) {
            $this->set('batch', $batch);
            $this->set('pageTitle', t('Map Content'));
            $this->set('mapper', $mapper);
            $this->set('items', $mapper->getItems($batch));
            $this->set('targetItemList', new TargetItemList($batch, $mapper));
            $this->render('/dashboard/system/migration/map_content');
        } else {
            $this->view();
        }
    }
}
