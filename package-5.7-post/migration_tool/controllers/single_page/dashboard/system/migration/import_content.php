<?
namespace Concrete\Package\MigrationTool\Controller\SinglePage\Dashboard\System\Migration;

use Concrete\Package\MigrationTool\Page\Controller\DashboardPageController;
use PortlandLabs\Concrete5\MigrationTool\Entity\ImportBatch;
use PortlandLabs\Concrete5\MigrationTool\CIF\Parser;

class ImportContent extends DashboardPageController
{

    public function add_batch()
    {
        if (!$this->token->validate('add_batch')) {
            $this->error->add($this->token->getErrorMessage());
        }
        if (!$this->error->has()) {
            $batch = new ImportBatch();
            $batch->setNotes($this->request->request->get('notes'));
            $this->entityManager->persist($batch);
            $this->entityManager->flush();
            $this->flash('success', t('Batch added successfully.'));
            $this->redirect('/dashboard/system/migration');
        }
        $this->view();
    }

    public function delete_batch()
    {
        if (!$this->token->validate('delete_batch')) {
            $this->error->add($this->token->getErrorMessage());
        }
        if (!$this->error->has()) {
            $r = $this->entityManager->getRepository('\PortlandLabs\Concrete5\MigrationTool\Entity\ImportBatch');
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

        $r = $this->entityManager->getRepository('\PortlandLabs\Concrete5\MigrationTool\Entity\ImportBatch');
        $batch = $r->findOneById($this->request->request->get('id'));
        if (!is_object($batch)) {
            $this->error->add(t('Invalid batch.'));
        }

        if (!$this->error->has()) {
            try {
                $parser = new Parser($_FILES['xml']['tmp_name']);
            } catch(\Exception $e) {
                $this->error->add(t('Unable to parse XML file: %s', $e->getMessage()));
            }
        }
        $this->view_batch($this->request->request->get('id'));
    }

    public function view()
    {
        $r = $this->entityManager->getRepository('\PortlandLabs\Concrete5\MigrationTool\Entity\ImportBatch');
        $batches = $r->findAll(array(), array('date' => 'desc'));
        $this->set('batches', $batches);
    }

    public function view_batch($id = null)
    {
        $r = $this->entityManager->getRepository('\PortlandLabs\Concrete5\MigrationTool\Entity\ImportBatch');
        $batch = $r->findOneById($id);
        if (is_object($batch)) {
            $this->set('batch', $batch);
            $this->set('pageTitle', t('Import Batch'));
            $this->render('/dashboard/system/migration/view_batch');
        }
        $this->view();
    }

}