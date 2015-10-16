<?php

namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use Concrete\Core\Page\Stack\Stack;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\MapperInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\TargetItemList;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\IgnoredTargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\UnmappedTargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Area;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

class PublishStackContentRoutine extends AbstractPageRoutine
{
    public function execute(Batch $batch)
    {
        $this->batch = $batch;
        $stacks = $batch->getObjectCollection('stack');
        foreach($stacks->getStacks() as $stack) {
            if (!$stack->getPublisherValidator()->skipItem()) {
                $s = Stack::getByName($stack->getName());
                if (is_object($s)) {
                    foreach($stack->getBlocks() as $block) {
                        $bt = $this->getTargetItem('block_type', $block->getType());
                        if (is_object($bt)) {
                            $value = $block->getBlockValue();
                            $publisher = $value->getPublisher();
                            $area = new Area();
                            $area->setName(STACKS_AREA_NAME);
                            $publisher->publish($bt, $s, $area, $value);
                        }
                    }
                }
            }
        }
    }
}
