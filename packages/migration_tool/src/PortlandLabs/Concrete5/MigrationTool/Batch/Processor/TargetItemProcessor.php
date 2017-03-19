<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Processor;

use Concrete\Core\Foundation\Processor\ProcessorQueue as ProcessorQueue;
use Concrete\Core\Foundation\Processor\TargetInterface;
use Concrete\Core\Foundation\Queue\Queue;
use PortlandLabs\Concrete5\MigrationTool\Batch\Processor\Task\MapContentTypesTask;

defined('C5_EXECUTE') or die("Access Denied.");

class TargetItemProcessor extends ProcessorQueue
{
    protected $section;

    public function __construct(TargetInterface $target)
    {
        parent::__construct($target);
        $this->setQueue(Queue::get('target_item_processor'));
        $this->registerTask(new MapContentTypesTask());
    }
}
