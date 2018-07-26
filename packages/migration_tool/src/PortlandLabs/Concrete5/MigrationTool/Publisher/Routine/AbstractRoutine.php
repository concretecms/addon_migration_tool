<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\LoggerInterface;

defined('C5_EXECUTE') or die("Access Denied.");

abstract class AbstractRoutine implements RoutineInterface
{

    abstract public function getCommandClass();

    public function getPublisherCommands(BatchInterface $batch, LoggerInterface $logger)
    {
        $class = $this->getCommandClass();
        return [new $class($batch->getId(), $logger->getLog()->getId())];
    }

}
