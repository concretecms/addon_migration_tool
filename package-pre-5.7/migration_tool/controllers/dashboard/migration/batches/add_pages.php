<?

Loader::model('migration_batch', 'migration_tool');

class DashboardMigrationBatchesAddPagesController extends DashboardBaseController
{

    public function view($id = null)
    {
        if ($id) {
            $batch = MigrationBatch::getByID($id);
        }
        if (is_object($batch)) {
            $types = CollectionType::getList();
            $pagetypes = array('' => t('** No Filtering'));
            foreach($types as $type) {
                $pagetypes[$type->getCollectionTypeID()] = $type->getCollectionTypeName();
            }
            $startingPoint = intval($_GET['startingPoint']);
            $datetime = Loader::helper('form/date_time')->translate('datetime', $_GET);
            if ($_GET['keywords'] || $_GET['ctID'] || $startingPoint > 0 || $datetime) {

                Loader::model("page_list");
                $keywords = $_GET['keywords'];
                $ctID = $_GET['ctID'];
                $pl = new PageList();
                $pl->ignorePermissions();
                $pl->ignoreAliases();
                if ($startingPoint) {
                    $parent = Page::getByID($startingPoint, 'ACTIVE');
                    $pl->filterByPath($parent->getcollectionPath());
                }
                if ($datetime) {
                    $pl->filterByPublicDate($datetime, '>=');
                }

                if ($ctID) {
                    $pl->filterByCollectionTypeID($ctID);
                }
                if ($keywords) {
                    $pl->filterByKeywords($keywords, true);
                }
                $pl->setItemsPerPage(1000);
                $results = $pl->getPage();
                $this->set('results', $results);
            }
            $this->set('datetime', $datetime);
            $this->set('pagetypes', $pagetypes);
            $this->set('batch', $batch);
        } else {
            throw new Exception(t('Invalid batch'));
        }
    }

    public function submit()
    {
        $id = $_POST['id'];
        if ($id) {
            $batch = MigrationBatch::getByID($id);
        }
        if (!is_object($batch)) {
            $this->error->add(t('Invalid Batch'));
        }
        if (!$this->token->validate("submit")) {
            $this->error->add($this->token->getErrorMessage());
        }
        $r = new stdClass;
        if (!$this->error->has()) {

            $r->error = false;
            $r->pages = array();
            foreach((array) $_POST['batchPageID'] as $cID) {
                $r->pages[] = $cID;
                $batch->addPageID($cID);
            }

        } else {
            $r->error = true;
            $r->messages = $this->error->getList();
        }
        print Loader::helper('json')->encode($r);
        exit;
    }


}