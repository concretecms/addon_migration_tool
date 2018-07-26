<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreateSinglePageStructureCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\LoggerInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class CreateSinglePageStructureRoutine extends AbstractPageRoutine
{
    public function getPageCollection(BatchInterface $batch)
    {
        return $batch->getObjectCollection('single_page');
    }

    public function getPageRoutineCommand(BatchInterface $batch, LoggerInterface $logger, $pageId)
    {
        return new CreateSinglePageStructureCommand($batch->getId(), $logger->getLog()->getId(), $pageId);
    }
}
