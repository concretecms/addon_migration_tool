<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\ClearBatchCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreateAttributeCategoriesCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreateConversationDataCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreateExpressEntitiesCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreateExpressEntryCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreateGroupsCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreateJobSetsCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\LoggerInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class CreateExpressEntriesRoutine implements RoutineInterface
{

    public function getPublisherCommands(BatchInterface $batch, LoggerInterface $logger)
    {
        $entries = $batch->getObjectCollection('express_entry');
        if (!$entries) {
            return array();
        }
        $actions = array();
        foreach ($entries->getEntries() as $entry) {
            if (!$entry->getPublisherValidator()->skipItem()) {
                $action = new CreateExpressEntryCommand($batch, $logger, $entry->getId());
                $actions[] = $action;
            }
        }
        return $actions;

    }
}
