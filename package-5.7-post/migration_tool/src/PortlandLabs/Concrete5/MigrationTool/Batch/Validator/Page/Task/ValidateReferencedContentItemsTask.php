<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page\Task;

use Concrete\Core\Foundation\Processor\ActionInterface;
use Concrete\Core\Foundation\Processor\TaskInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\TargetItemList;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\Area;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page\Content\Factory;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\UnmappedTargetItem;

defined('C5_EXECUTE') or die("Access Denied.");

class ValidateReferencedContentItemsTask implements TaskInterface
{

    public function execute(ActionInterface $action)
    {
        $subject = $action->getSubject();
        $areas = $subject->getAreas();
        $target = $action->getTarget();
        foreach($areas as $area) {
            $blocks = $area->getBlocks();
            foreach($blocks as $block) {
                $inspector = $block->getBlockValue()->getInspector();
                $items = $inspector->getMatchedItems();
                foreach($items as $item) {
                    $validatorFactory = new Factory($item);
                    $validator = $validatorFactory->getValidator();
                    if (!$validator->itemExists($item, $target->getBatch())) {
                        $validator->addMissingItemMessage($item, $action->getTarget());
                    }
                }
            }
        }
    }

    public function finish(ActionInterface $action)
    {

    }

}
