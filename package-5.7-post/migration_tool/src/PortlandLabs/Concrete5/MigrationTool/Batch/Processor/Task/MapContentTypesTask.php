<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Processor\Task;

use Concrete\Core\Foundation\Processor\ActionInterface;
use Concrete\Core\Foundation\Processor\TaskInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\TargetItemList;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BatchTargetItem;

defined('C5_EXECUTE') or die("Access Denied.");

class MapContentTypesTask implements TaskInterface
{

    public function execute(ActionInterface $action)
    {
        return;
    }

    public function finish(ActionInterface $action)
    {
        $target = $action->getTarget();
        $batch = $target->getBatch();
        $targetItems = array();
        $mappers = \Core::make('migration/batch/mapper/manager');
        foreach($mappers->getDrivers() as $mapper) {
            foreach($mapper->getItems($batch) as $item) {
                $targetItem = $mapper->getMatchedTargetItem($item);
                if (is_object($targetItem)) {
                    $targetItem->setSourceItemIdentifier($item->getIdentifier());
                    $targetItems[] = $targetItem;
                }
            }
        }

        foreach($targetItems as $targetItem) {
            $batchTargetItem = new BatchTargetItem();
            $batchTargetItem->setBatch($batch);
            $batchTargetItem->setTargetItem($targetItem);
            $batch->target_items->add($batchTargetItem);
        }
    }

}
