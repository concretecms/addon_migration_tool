<?php

namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Command;

use League\Tactician\Bernard\QueueableCommand;

class CreateExpressEntryCommand extends PublisherCommand
{

    protected $entryId;

    public function __construct($batchId, $logId, $entryId)
    {
        parent::__construct($batchId, $logId);
        $this->entryId = $entryId;
    }

    /**
     * @return mixed
     */
    public function getEntryId()
    {
        return $this->entryId;
    }

    /**
     * @param mixed $entryId
     */
    public function setEntryId($entryId)
    {
        $this->entryId = $entryId;
    }



}