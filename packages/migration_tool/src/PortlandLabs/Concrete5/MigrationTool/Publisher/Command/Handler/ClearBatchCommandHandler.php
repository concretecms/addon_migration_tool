<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Command\Handler;


use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\ClearBatchCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\PublisherCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\Logger;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\LoggerInterface;

class ClearBatchCommandHandler extends AbstractHandler
{

    public function execute(BatchInterface $batch, LoggerInterface $logger)
    {
        // Has the batch already been created? If so, we move to trash.
        $orphaned = \Page::getByPath('/!import_batches/' . $batch->getId(), 'RECENT', $batch->getSite());
        if (is_object($orphaned) && !$orphaned->isError()) {
            $orphaned->moveToTrash();
        }
    }
}
