<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Task;

use Concrete\Core\Foundation\Processor\ActionInterface;
use Concrete\Core\Foundation\Processor\TaskInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\TargetItemList;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\Area;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\Attribute;
use PortlandLabs\Concrete5\MigrationTool\Batch\Page\Validator\Message;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\UnmappedTargetItem;

defined('C5_EXECUTE') or die("Access Denied.");

class ValidateBatchPagesTask implements TaskInterface
{

    public function execute(ActionInterface $action)
    {
        // Grab the target item for the page's page type.
        $subject = $action->getSubject();
        $target = $action->getTarget();
        $validator = \Core::make('migration/batch/page/validator');
        foreach($subject->getPages() as $page) {
            $messages = $validator->validate($subject, $page);
            foreach($messages as $message) {
                $target->addMessage($message);
            }
        }
    }

    public function finish(ActionInterface $action)
    {

    }

}
