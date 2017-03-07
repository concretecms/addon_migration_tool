<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\MapperManagerInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\IgnoredTargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\UnmappedTargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Page;

defined('C5_EXECUTE') or die("Access Denied.");

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
        return array('page_id');
    }

    public function __wakeup()
    {
        $this->populatePageObject($this->page_id);
    }

    protected function getPageByPath(Batch $batch, $path)
    {
        return \Page::getByPath('/!import_batches/' . $batch->getID() . $path,
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

    public function getTargetItem($batch, $mapper, $subject)
    {
        if ($subject) {
            /**
             * @var MapperManagerInterface
             */
            $mappers = \Core::make('migration/manager/mapping');
            $mapper = $mappers->driver($mapper);
            $list = $mappers->createTargetItemList($batch, $mapper);
            $item = new Item($subject);
            $targetItem = $list->getSelectedTargetItem($item);
            if (!($targetItem instanceof UnmappedTargetItem || $targetItem instanceof IgnoredTargetItem)) {
                return $mapper->getTargetItemContentObject($targetItem);
            }
        }
    }

    protected function getBatchParentPage(BatchInterface $batch)
    {
        $page = \Page::getByPath('/!import_batches/' . $batch->getID(), 'RECENT', $batch->getSite()->getSiteTreeObject());
        if (is_object($page) && !$page->isError()) {
            return $page;
        }
    }
}
