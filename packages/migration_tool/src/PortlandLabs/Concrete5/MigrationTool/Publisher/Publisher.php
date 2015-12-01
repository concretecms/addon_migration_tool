<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

class Publisher
{
    protected $manager;
    protected $batch;

    public function __construct(Batch $batch)
    {
        $this->manager = \Core::make('migration/manager/publisher');
        $this->batch = $batch;
    }

    public function publish()
    {
        foreach ($this->manager->getDrivers() as $driver) {
            $driver->execute($this->batch);
        }
    }
}
