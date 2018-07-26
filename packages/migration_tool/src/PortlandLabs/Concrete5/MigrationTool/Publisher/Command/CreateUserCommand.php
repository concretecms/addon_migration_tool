<?php

namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Command;

use League\Tactician\Bernard\QueueableCommand;

class CreateUserCommand extends PublisherCommand
{

    protected $userId;

    public function __construct($batchId, $logId, $userId)
    {
        $this->userId = $userId;
        parent::__construct($batchId, $logId);
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }



}