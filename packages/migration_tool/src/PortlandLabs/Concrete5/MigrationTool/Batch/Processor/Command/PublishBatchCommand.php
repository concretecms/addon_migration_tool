<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Processor\Command;

use Concrete\Core\Foundation\Bus\Command\CommandInterface;

class PublishBatchCommand implements CommandInterface
{

    protected $batchId;

    public function __construct($batchId)
    {
        $this->batchId = $batchId;
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


}