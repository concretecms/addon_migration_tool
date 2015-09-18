<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Page\Validator\Task;

use Concrete\Core\Block\BlockType\BlockType;
use Concrete\Core\Foundation\Processor\ActionInterface;
use Concrete\Core\Foundation\Processor\TargetInterface;
use Concrete\Core\Foundation\Processor\TaskInterface;
use Concrete\Core\Page\Type\Type;
use PortlandLabs\Concrete5\MigrationTool\Batch\Page\Validator\Message;

defined('C5_EXECUTE') or die("Access Denied.");

class ValidateBlockTypeTask implements TaskInterface
{

    public function execute(ActionInterface $action)
    {
        $subject = $action->getSubject();
        $areas = $subject->getAreas();
        foreach($areas as $area) {
            $blocks = $area->getBlocks();
            foreach($blocks as $block) {
                $type = BlockType::getByHandle($block->getType());
                if (!is_object($type)) {
                    $action->getTarget()->addMessage(
                        new Message(t('Block Type <strong>%s</strong> does not exist.', $block->getType()))
                    );
                }
            }
        }
    }

    public function finish(ActionInterface $action)
    {

    }

}
