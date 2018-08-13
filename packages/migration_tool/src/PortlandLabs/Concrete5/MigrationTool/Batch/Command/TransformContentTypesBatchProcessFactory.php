<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Command;

use Concrete\Core\Application\Application;
use Concrete\Core\Foundation\Queue\Batch\BatchProcessFactoryInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\EmptyMapper;

class TransformContentTypesBatchProcessFactory implements BatchProcessFactoryInterface
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
        return 'transform_content_types';
    }

    public function getCommands($batch) : array
    {
        $mappers = $this->app->make('migration/manager/mapping');
        $transformers = \Core::make('migration/manager/transforms');
        $items = array();
        foreach ($transformers->getDrivers() as $transformer) {
            try {
                $mapper = $mappers->driver($transformer->getDriver());
            } catch (\Exception $e) {
                // No mapper for this type.}
                $mapper = new EmptyMapper();
            }

            $untransformed = $transformer->getUntransformedEntityObjects($mapper, $batch);
            foreach ($untransformed as $entity) {
                $items[] = array(
                    'entity' => $entity->getID(),
                    'mapper' => $mapper->getHandle(),
                    'transformer' => $transformer->getDriver(),
                );
            }
        }

        $commands = [];
        foreach($items as $item) {
            $command = new TransformContentTypesCommand(
                $batch->getID(), $item['entity'], $item['mapper'], $item['transformer']
            );
            $commands[] = $command;
        }

        return $commands;
    }
}