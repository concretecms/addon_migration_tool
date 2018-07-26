<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Command\Handler;

use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\LoggerInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class ClosePublisherLogCommandHandler extends AbstractHandler
{
    public function execute(BatchInterface $batch, LoggerInterface $logger)
    {
        $logger->closeLog($batch);
    }
}
