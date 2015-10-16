<?php

namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use Concrete\Core\Page\Stack\Stack;
use Concrete\Core\Page\Type\Type;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\MapperInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\TargetItemList;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\IgnoredTargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\UnmappedTargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

class CreateStackStructureRoutine implements RoutineInterface
{
    public function execute(Batch $batch)
    {
        $stacks = $batch->getObjectCollection('stack');
        foreach($stacks->getStacks() as $stack) {
            if (!$stack->getPublisherValidator()->skipItem()) {
                $s = Stack::getByName($stack->getName());
                if (!is_object($s)) {
                    if ($stack->getType()) {
                        $type = Stack::mapImportTextToType($stack->getType());
                        Stack::addStack($stack->getName(), $type);
                    } else {
                        Stack::addStack($stack->getName());
                    }
                }
            }
        }
    }
}
