<?

Loader::model('migration_batch', 'migration_tool');

class DashboardMigrationBatchesController extends DashboardBaseController
{

    public function update_batch()
    {
        $id = $_POST['id'];
        if ($id) {
            $batch = MigrationBatch::getByID($id);
        }
        if (!is_object($batch)) {
            $this->error->add(t('Invalid Batch'));
        }
        if (!$this->token->validate("update_batch")) {
            $this->error->add($this->token->getErrorMessage());
        }
        if (!$this->error->has()) {
            switch($_POST['action']) {
                case 'delete':
                    $batch->delete();
                    $this->redirect('/dashboard/migration/batches', 'batch_deleted');
                    break;
            }
        }
        $this->view_batch($_POST['id']);
    }

    public function remove_from_batch()
    {
        $id = $_POST['id'];
        if ($id) {
            $batch = MigrationBatch::getByID($id);
        }
        if (!is_object($batch)) {
            $this->error->add(t('Invalid Batch'));
        }
        if (!$this->token->validate("remove_from_batch")) {
            $this->error->add($this->token->getErrorMessage());
        }
        $r = new stdClass;
        if (!$this->error->has()) {

            $r->error = false;
            $r->pages = array();
            foreach((array) $_POST['batchPageID'] as $cID) {
                $r->pages[] = $cID;
                $batch->removePageID($cID);
            }

        } else {
            $r->error = true;
            $r->messages = $this->error->getList();
        }
        print Loader::helper('json')->encode($r);
        exit;
    }

    public function view_batch($id = null)
    {
        if ($id) {
            $batch = MigrationBatch::getByID($id);
        }
        if (is_object($batch)) {
            $this->set('batch', $batch);
            $this->set('pages', $batch->getPages());
        }
    }

    public function batch_deleted()
    {
        $this->set('message', t('Batch deleted.'));
        $this->view();
    }

    public function view()
    {
        $batches = MigrationBatch::getList();
        $this->set('batches', $batches);
    }

    public function submit() {
        if ($this->token->validate("submit")) {
            $batch = MigrationBatch::create($_POST['description']);
            $this->redirect('/dashboard/migration/batches', 'view_batch', $batch->getID());
        } else {
            $this->error->add($this->token->getErrorMessage());
        }
    }
}