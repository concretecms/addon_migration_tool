<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Processor;

use Concrete\Core\Foundation\Processor\ProcessorQueue as ProcessorQueue;
use Concrete\Core\Foundation\Processor\TargetInterface;
use Concrete\Core\Foundation\Queue\Queue;
use PortlandLabs\Concrete5\MigrationTool\Batch\Processor\Task\TransformContentTypesTask;

defined('C5_EXECUTE') or die("Access Denied.");

class UntransformedItemProcessor extends ProcessorQueue
{
    protected $section;

    protected $itemsPerBatch = 100;


    public function __construct(TargetInterface $target)
    {
        parent::__construct($target);
        $mappers = \Core::make('migration/manager/mapping');
        $this->setQueue(Queue::get('untransformed_item_processor'));
        $this->registerTask(new TransformContentTypesTask($mappers));
    }
}
