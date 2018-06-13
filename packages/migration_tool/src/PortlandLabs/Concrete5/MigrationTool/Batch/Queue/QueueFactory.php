<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Queue;

use Concrete\Core\Foundation\Queue\QueueService;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

class QueueFactory
{

    protected $queueService;

    public function __construct(QueueService $queueService)
    {
        $this->queueService = $queueService;
    }

    private function getQueue()
    {
        return $this->queueService->get('migration_tool');
    }
    public function getMapperQueue(Batch $batch)
    {
        return $this->getQueue();
    }

    public function getTransformerQueue(Batch $batch)
    {
        return $this->getQueue();
    }

    public function getPublisherQueue(Batch $batch)
    {
        return $this->getQueue();
    }

    public function getActiveQueue(Batch $batch)
    {
        $queue = $this->getMapperQueue($batch);
        if ($queue->count() >0 ) {
            return $queue;
        }
        $queue = $this->getTransformerQueue($batch);
        if ($queue->count() >0 ) {
            return $queue;
        }
        $queue = $this->getPublisherQueue($batch);
        if ($queue->count() >0 ) {
            return $queue;
        }
        return null;
    }

}