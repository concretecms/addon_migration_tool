<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreatePageStructureCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\LoggerInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class CreatePageStructureRoutine extends AbstractPageRoutine
{
    public function getPageRoutineCommand(BatchInterface $batch, LoggerInterface $logger, $pageId)
    {
        return new CreatePageStructureCommand($batch->getId(), $logger->getLog()->getId(), $pageId);
    }
}
