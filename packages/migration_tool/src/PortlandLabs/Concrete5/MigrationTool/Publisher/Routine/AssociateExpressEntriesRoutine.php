<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use Concrete\Core\Attribute\Key\Category;
use PortlandLabs\CalendarImport\Entity\Import\Event;
use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\MapperManagerInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\IgnoredTargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\UnmappedTargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\AssociateExpressEntryCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\LoggerInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Routine\AbstractPageRoutine;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Routine\RoutineInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Routine\AssociateExpressEntriesRoutineAction;

class AssociateExpressEntriesRoutine implements RoutineInterface
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
                $action = new AssociateExpressEntryCommand($batch->getId(), $logger->getLog()->getId(), $entry->getId());
                $actions[] = $action;
            }
        }

        return $actions;

    }

}