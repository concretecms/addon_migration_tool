<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Processor;

use Concrete\Core\Foundation\Processor\TargetInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

class Target implements TargetInterface
{
    protected $batch;

    public function __construct(Batch $batch)
    {
        $this->batch = $batch;
    }

    /**
     * @return Section
     */
    public function getBatch()
    {
        return $this->batch;
    }

    public function getItems()
    {
        return $this->batch->getPages();
    }
}
