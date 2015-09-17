<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Page\Validator\Task;

use Concrete\Core\Foundation\Processor\ActionInterface;
use Concrete\Core\Foundation\Processor\TargetInterface;
use Concrete\Core\Foundation\Processor\TaskInterface;
use Concrete\Core\Page\Type\Type;
use PortlandLabs\Concrete5\MigrationTool\Batch\Page\Validator\Message;

defined('C5_EXECUTE') or die("Access Denied.");

class ValidatePageTypeTask implements TaskInterface
{

    public function execute(ActionInterface $action)
    {
        $subject = $action->getSubject();
        $type = Type::getByHandle($subject->getType());
        if (!is_object($type)) {
            $action->getTarget()->addMessage(
                new Message(t('Page type %s does not exist', $subject->getType()))
            );
        }
    }

    public function finish(ActionInterface $action)
    {

    }

}
