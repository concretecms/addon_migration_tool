<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page\Task;

use Concrete\Core\Block\BlockType\BlockType;
use Concrete\Core\Foundation\Processor\ActionInterface;
use Concrete\Core\Foundation\Processor\TargetInterface;
use Concrete\Core\Foundation\Processor\TaskInterface;
use Concrete\Core\Page\Type\Type;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\TargetItemList;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Message;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\UnmappedTargetItem;

defined('C5_EXECUTE') or die("Access Denied.");

class ValidateBlocksTask implements TaskInterface
{

    public function execute(ActionInterface $action)
    {
        $subject = $action->getSubject();
        $target = $action->getTarget();
        $areas = $subject->getAreas();
        foreach($areas as $area) {
            $blocks = $area->getBlocks();
            $validator = \Core::make('migration/batch/block/validator', array($target->getBatch()));
            $messages = $validator->validate($blocks);
            if ($messages && count($messages)) {
                foreach($messages as $message) {
                    $target->addMessage($message);
                }
            }
        }
    }

    public function finish(ActionInterface $action)
    {

    }

}
