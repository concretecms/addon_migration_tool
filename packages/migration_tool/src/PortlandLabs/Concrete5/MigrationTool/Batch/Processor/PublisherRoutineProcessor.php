<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Processor;

use Concrete\Core\Foundation\Processor\ProcessorQueue as ProcessorQueue;
use Concrete\Core\Foundation\Processor\TargetInterface;
use Concrete\Core\Foundation\Queue\Queue;
use PortlandLabs\Concrete5\MigrationTool\Batch\Processor\Task\PublishContentTask;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\Logger;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\LoggerInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class PublisherRoutineProcessor extends ProcessorQueue
{
    protected $section;

    protected $itemsPerBatch = 50;

    public function __construct(TargetInterface $target)
    {
        parent::__construct($target);
        $this->setQueue(Queue::get('publisher_routine_processor'));
        $this->registerTask(new PublishContentTask());
    }

    public function process()
    {
        $u = new \User();
        $user = $u->getUserInfoObject()->getEntityObject();

        $logger = \Core::make(Logger::class);
        /**
         * @var $logger Logger
         */
        $logger->openLog($this->target->getBatch(), $user);

        $validator = \Core::make('migration/batch/validator');
        $messages = $validator->validate($this->target->getBatch());
        $formatter = $validator->getFormatter($messages);
        foreach($formatter->getSortedMessages($messages) as $message) {
            $logger->logMessage($message);
        }

        $this->target->setLogger($logger);
        parent::process();
    }

}
