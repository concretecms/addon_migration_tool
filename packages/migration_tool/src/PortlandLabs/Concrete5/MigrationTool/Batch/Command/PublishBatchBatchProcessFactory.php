<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Command;

use Concrete\Core\Application\Application;
use Concrete\Core\Foundation\Queue\Batch\BatchProcessFactoryInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\EmptyMapper;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\Logger;

class PublishBatchBatchProcessFactory implements BatchProcessFactoryInterface
{

    /**
     * @var Logger
     */
    protected $logger;

    /**
     * @var Application
     */
    protected $app;

    public function __construct(Application $app, Logger $logger)
    {
        $this->app = $app;
        $this->logger = $logger;
    }

    public function getBatchHandle()
    {
        return 'publish_batch';
    }

    public function getCommands($batch) : array
    {
        $commands = [];
        $publishers = $this->app->make('migration/manager/publisher');
        foreach ($publishers->getDrivers() as $driver) {
            foreach ($driver->getPublisherCommands($batch, $this->logger) as $command) {
                $commands[] = $command;
            }
        }

        return $commands;
    }
}