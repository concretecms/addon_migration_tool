<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Page\Validator;

use Concrete\Core\Foundation\Processor\Processor;
use Concrete\Core\Foundation\Processor\TaskInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Page;

defined('C5_EXECUTE') or die("Access Denied.");

class Validator
{

    protected $tasks = array();

    public function registerTask(TaskInterface $task)
    {
        $this->tasks[] = $task;
    }

    public function validate(Page $page)
    {
        $target = new ValidatorTarget($page);
        $processor = new Processor($target);
        foreach($this->tasks as $task) {
            $processor->registerTask($task);
        }
        $processor->process();
        return $target->getMessages();
    }
}