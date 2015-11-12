<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator;

use Concrete\Core\Foundation\Processor\Processor;
use Concrete\Core\Foundation\Processor\TaskInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\BatchMessageCollectionFormatter;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Page;

defined('C5_EXECUTE') or die("Access Denied.");

class BatchValidator
{

    protected $tasks = array();

    public function registerTask(TaskInterface $task)
    {
        $this->tasks[] = $task;
    }

    public function validate(Batch $batch)
    {
        $target = new ValidatorTarget($batch);
        $processor = new Processor($target);
        foreach($this->tasks as $task) {
            $processor->registerTask($task);
        }
        $processor->process();
        return $target->getMessages();
    }


    public function getFormatter(MessageCollection $collection)
    {
        return new BatchMessageCollectionFormatter($collection);
    }
}