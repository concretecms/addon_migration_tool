<?php

namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Command;

use Concrete\Core\Foundation\Queue\Batch\Command\BatchableCommandInterface;
use League\Tactician\Bernard\QueueableCommand;

abstract class PublisherCommand implements BatchableCommandInterface, QueueableCommand
{

    protected $batchId;

    protected $logId;

    public function getName()
    {
        return 'default';
    }

    public function __construct($batchId, $logId)
    {
        $this->batchId = $batchId;
        $this->logId = $logId;
    }

    /**
     * @return mixed
     */
    public function getBatchId()
    {
        return $this->batchId;
    }

    /**
     * @param mixed $batchId
     */
    public function setBatchId($batchId)
    {
        $this->batchId = $batchId;
    }

    /**
     * @return mixed
     */
    public function getLogId()
    {
        return $this->logId;
    }

    /**
     * @param mixed $logId
     */
    public function setLogId($logId)
    {
        $this->logId = $logId;
    }


    public function getBatchHandle()
    {
        return 'publish_batch';
    }

}