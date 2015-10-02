<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page;

use Concrete\Core\Foundation\Processor\Processor;
use Concrete\Core\Foundation\Processor\TaskInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ItemValidatorInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Page;

defined('C5_EXECUTE') or die("Access Denied.");

class Validator implements ItemValidatorInterface
{

    protected $tasks = array();

    public function registerTask(TaskInterface $task)
    {
        $this->tasks[] = $task;
    }

    public function validate(Batch $batch, $page)
    {
        try {
            $target = new ValidatorTarget($batch, $page);
            $processor = new Processor($target);
            foreach($this->tasks as $task) {
                $processor->registerTask($task);
            }
            $processor->process();
        } catch(\Exception $e) {
            print $e->getMessage();
        }
        return $target->getMessages();
    }
}