<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use Concrete\Core\Page\Page as CorePage;
use Concrete\Core\Page\Type\Type;
use Concrete\Core\Utility\Service\Text;
use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\TargetItemList;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Page;

defined('C5_EXECUTE') or die('Access Denied.');

abstract class AbstractPageAction implements RoutineActionInterface
{
    protected $page;
    protected $page_id;

    public function __construct($page) // can't type hint, might be a stack. probably should have an interface.
    {
        $this->page = $page;
        $this->page_id = $page->getID();
    }

    public function __sleep()
    {
        return ['page_id'];
    }

    public function __wakeup()
    {
        $this->populatePageObject($this->page_id);
    }

    protected function getPageByPath(Batch $batch, $path)
    {
        return CorePage::getByPath('/!import_batches/' . $batch->getID() . $path,
            'RECENT',
            $batch->getSite()->getSiteTreeObject()
        );
    }

    public function populatePageObject($id)
    {
        $entityManager = \Database::connection()->getEntityManager();
        $r = $entityManager->getRepository('\PortlandLabs\Concrete5\MigrationTool\Entity\Import\Page');
        $this->page = $r->findOneById($id);
    }

    protected function ensureParentPageExists(Batch $batch, Page $page)
    {
        $service = new Text();
        $path = trim($page->getBatchPath(), '/');
        $paths = explode('/', $path);
        $batchParent = $this->getBatchParentPage($batch);
        $parent = $batchParent;
        $prefix = '';

        array_pop($paths);

        foreach ($paths as $path) {
            $currentPath = $prefix . $path;
            $c = CorePage::getByPath($batchParent->getCollectionPath() . '/' . $currentPath, 'RECENT', $batch->getSite()->getSiteTreeObject());
            if ($c->isError() && $c->getError() == COLLECTION_NOT_FOUND) {
                $data = [];
                $data['cHandle'] = $path;
                $data['name'] = $service->unhandle($data['cHandle']);
                $data['uID'] = USER_SUPER_ID;
                $parent = $parent->add(null, $data);
            } else {
                $parent = $c;
            }
            $prefix = $currentPath . '/';
        }

        return $parent;
    }

    public function getTargetItem($batch, $mapper, $subject)
    {
        return TargetItemList::getBatchTargetItem($batch, $mapper, $subject);
    }

    protected function getBatchParentPage(BatchInterface $batch)
    {
        $page = CorePage::getByPath('/!import_batches/' . $batch->getID(), 'RECENT', $batch->getSite()->getSiteTreeObject());
        if (is_object($page) && !$page->isError()) {
            return $page;
        } else {
            return $this->addBatchParent($batch);
        }
    }

    protected function addBatchParent(BatchInterface $batch)
    {
        $holder = CorePage::getByPath('/!import_batches', 'RECENT', $batch->getSite()->getSiteTreeObject());
        $type = Type::getByHandle('import_batch');

        return $holder->add($type, [
            'cName' => $batch->getID(),
            'pkgID' => \Package::getByHandle('migration_tool')->getPackageID(),
        ]);
    }
}
