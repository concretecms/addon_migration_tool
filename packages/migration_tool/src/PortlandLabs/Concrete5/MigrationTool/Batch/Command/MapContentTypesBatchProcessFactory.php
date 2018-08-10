<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Command;

use Concrete\Core\Application\Application;
use Concrete\Core\Foundation\Queue\Batch\BatchProcessFactoryInterface;

class MapContentTypesBatchProcessFactory implements BatchProcessFactoryInterface
{

    /**
     * @var Application
     */
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function getBatchHandle()
    {
        return 'map_content_types';
    }

    public function getCommands($batch) : array
    {
        $mappers = $this->app->make('migration/manager/mapping');
        $commands = array();
        foreach ($mappers->getDrivers() as $mapper) {
            foreach ($mapper->getItems($batch) as $item) {
                $r = array();
                $r['mapper'] = $mapper->getHandle();
                $r['item'] = $item->getIdentifier();
                $items[] = $r;
            }
        }

        foreach($items as $item) {
            $command = new MapContentTypesCommand(
                $batch->getID(), $item['mapper'], $item['item']
            );
            $commands[] = $command;
        }

        return $commands;
    }
}