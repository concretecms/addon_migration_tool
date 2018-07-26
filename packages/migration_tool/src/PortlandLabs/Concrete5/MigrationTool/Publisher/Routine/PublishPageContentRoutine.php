<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\PublishPageContentCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\LoggerInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class PublishPageContentRoutine extends AbstractPageRoutine
{
    public function getPageRoutineCommand(BatchInterface $batch, LoggerInterface $logger, $pageId)
    {
        return new PublishPageContentCommand($batch->getId(), $logger->getLog()->getId(), $pageId);
    }
}
