<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Processor\Task;

use Concrete\Core\Foundation\Processor\ActionInterface;
use Concrete\Core\Foundation\Processor\TaskInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\MapperManagerInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\TargetItemList;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BatchTargetItem;

defined('C5_EXECUTE') or die("Access Denied.");

class MapContentTypesTask implements TaskInterface
{

    protected $mappers;

    public function __construct(MapperManagerInterface $mappers)
    {
        $this->mappers = $mappers;
    }

    public function execute(ActionInterface $action)
    {
        return;
    }

    public function finish(ActionInterface $action)
    {
        $target = $action->getTarget();
        $batch = $target->getBatch();

        $targetItems = array();
        foreach ($this->mappers->getDrivers() as $mapper) {
            $targetItemList = $this->mappers->createTargetItemList($batch, $mapper);
            foreach ($mapper->getItems($batch) as $item) {
                $targetItem = $targetItemList->getMatchedTargetItem($item);
                if (is_object($targetItem)) {
                    $targetItems[] = $targetItem;
                }
            }
        }

        foreach ($targetItems as $targetItem) {
            $batchTargetItem = $this->mappers->createBatchTargetItem();
            $batchTargetItem->setBatch($batch);
            $batchTargetItem->setTargetItem($targetItem);
            $batch->target_items->add($batchTargetItem);
        }
    }
}
