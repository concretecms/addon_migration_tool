<?
namespace Concrete\Package\MigrationTool\Controller\SinglePage\Dashboard\System\Migration;

use Concrete\Core\Foundation\Processor\Processor;
use Concrete\Package\MigrationTool\Page\Controller\DashboardPageController;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\TargetItemList;
use PortlandLabs\Concrete5\MigrationTool\Batch\Processor\Target;
use PortlandLabs\Concrete5\MigrationTool\Batch\Processor\Task\MapContentTypesTask;
use PortlandLabs\Concrete5\MigrationTool\Batch\Processor\Task\NormalizePagePathsTask;
use PortlandLabs\Concrete5\MigrationTool\Batch\Publisher;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\CIF\Parser;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BatchTargetItem;

class ImportContent extends DashboardPageController
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
            $this->redirect('/dashboard/system/migration/import_content', 'view_batch', $batch->getId());
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
                $this->entityManager->remove($batch);
                $this->entityManager->flush();
                $this->flash('success', t('Batch removed successfully.'));
                $this->redirect('/dashboard/system/migration');
            }
        }
        $this->view();
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
                foreach($batch->getPages() as $entity) {
                    $entity->setBatch(null);
                    $this->entityManager->remove($entity);
                }
                foreach($batch->getTargetItems() as $targetItem) {
                    $targetItem->setBatch(null);
                    $this->entityManager->remove($targetItem);
                }
                $this->entityManager->flush();
                $this->flash('success', t('Batch cleared successfully.'));
                $this->redirect('/dashboard/system/migration/import_content', 'view_batch', $batch->getId());
            }
        }
        $this->view();
    }


    public function add_content_to_batch()
    {
        if (!$this->token->validate('add_content_to_batch')) {
            $this->error->add($this->token->getErrorMessage());
        }

        if (!is_uploaded_file($_FILES['xml']['tmp_name'])) {
            $this->error->add(t('Invalid XML file.'));
        } else {
            if ($_FILES['xml']['type'] != 'text/xml') {
                $this->error->add(t('File does not appear to be an XML file.'));
            }
        }

        $r = $this->entityManager->getRepository('\PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch');
        $batch = $r->findOneById($this->request->request->get('id'));
        if (!is_object($batch)) {
            $this->error->add(t('Invalid batch.'));
        }

        if (!$this->error->has()) {
            try {
                $parser = new Parser($_FILES['xml']['tmp_name']);
                foreach($parser->getPageEntityObjects() as $entity) {
                    $entity->setBatch($batch);
                    $batch->pages->add($entity);
                }

                $target = new Target($batch);
                $processor = new Processor($target);
                $processor->registerTask(new NormalizePagePathsTask());
                $processor->registerTask(new MapContentTypesTask());
                $processor->process();

                $this->entityManager->persist($batch);
                $this->entityManager->flush();
                $this->flash('success', t('Content added to batch successfully.'));
                $this->redirect('/dashboard/system/migration/import_content', 'view_batch', $batch->getId());
            } catch(\Exception $e) {
                $this->error->add(t('Unable to parse XML file: %s', $e->getMessage()));
            }
        }
        $this->view_batch($this->request->request->get('id'));
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
                $publisher->createInterimPages();
                $this->flash('success', t('Batch drafts published successfully.'));
                $this->redirect('/dashboard/system/migration/import_content', 'view_batch', $batch->getId());
            }
        }
        $this->view();
    }

    public function view()
    {
        $r = $this->entityManager->getRepository('\PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch');
        $batches = $r->findAll(array(), array('date' => 'desc'));
        $this->set('batches', $batches);
    }

    public function view_batch($id = null)
    {
        $r = $this->entityManager->getRepository('\PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch');
        $batch = $r->findOneById($id);
        if (is_object($batch)) {
            $this->set('batch', $batch);
            $this->set('pageTitle', t('Import Batch'));
            $this->set('mappers', \Core::make('migration/batch/mapper/manager'));
            $this->render('/dashboard/system/migration/view_batch');

        }
        $this->view();
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

        $mappers = \Core::make('migration/batch/mapper/manager');
        $mapper = $mappers->driver($this->request->request->get('mapper'));
        if (!is_object($mapper)) {
            $this->error->add(t('Invalid mapping type.'));
        }

        if (!$this->error->has()) {
            // First, delete all target items for this particular type, since we're going to re-map
            // them in the post below.
            $r = $this->entityManager->getRepository('\PortlandLabs\Concrete5\MigrationTool\Entity\Import\BatchTargetItem');
            $items = $r->findBy(array(
                'batch' => $batch
            ));
            foreach($items as $item) {
                if ($item->getTargetItem()->getItemType() == $mapper->getHandle()) {
                    $this->entityManager->remove($item);
                }
            }
            $this->entityManager->flush();

            $items = $mapper->getItems($batch);
            $post = $this->request->request->get('targetItem');
            $targetItemList = new TargetItemList($batch, $mapper);

            foreach($items as $item) {
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

            $this->flash('message', t('Batch mappings updated.'));
            $this->redirect('/dashboard/system/migration/import_content', 'view_batch', $batch->getId());
        }
    }

    public function map_content($id = null, $type = null)
    {
        $r = $this->entityManager->getRepository('\PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch');
        $batch = $r->findOneById($id);
        $mappers = \Core::make('migration/batch/mapper/manager');
        $mapper = $mappers->driver($type);
        if (is_object($batch) && is_object($mapper)) {
            $this->set('batch', $batch);
            $this->set('pageTitle', t('Map Content'));
            $this->set('mapper', $mapper);
            $this->set('items', $mapper->getItems($batch));
            $this->set('targetItemList', new TargetItemList($batch, $mapper));
            $this->render('/dashboard/system/migration/map_content');

        }
        $this->view();
    }


}