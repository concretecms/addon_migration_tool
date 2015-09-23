<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Processor\Task;

use Concrete\Core\Foundation\Processor\ActionInterface;
use Concrete\Core\Foundation\Processor\TaskInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\IgnoredTargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\UnmappedTargetItem;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\TargetItemList;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\TransformerInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BatchTargetItem;

defined('C5_EXECUTE') or die("Access Denied.");

class TransformContentTypesTask implements TaskInterface
{

    public function execute(ActionInterface $action)
    {
        return;
    }

    public function finish(ActionInterface $action)
    {
        $target = $action->getTarget();
        $batch = $target->getBatch();
        $transformers = \Core::make('migration/manager/transforms');
        foreach($transformers->getDrivers() as $transformer) {
            $targetItemList = new TargetItemList($batch, $transformer->getMapper());
            $items = $transformer->getUntransformedEntityObjects();
            foreach($items as $entity) {
                $item = $transformer->getItem($entity);
                if (is_object($item)) {
                    $targetItem = $targetItemList->getMatchedTargetItem($item);
                    if (is_object($targetItem)) {
                        if (!($targetItem instanceof UnmappedTargetItem || $target instanceof IgnoredTargetItem)) {
                            $transformer->transform($entity, $item, $targetItem);
                        }
                    }
                }
            }
        }
    }
}
