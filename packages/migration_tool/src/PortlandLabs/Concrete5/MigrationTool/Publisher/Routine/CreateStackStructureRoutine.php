<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use Concrete\Core\Page\Stack\Stack;
use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\ObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Command\CreateStackStructureCommand;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\LoggerInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class CreateStackStructureRoutine extends AbstractPageRoutine
{
    public function getPageRoutineCommand(BatchInterface $batch, LoggerInterface $logger, $pageId)
    {
        return new CreateStackStructureCommand($batch->getId(), $logger->getLog()->getId(), $pageId);
    }

    public function getPageCollection(BatchInterface $batch)
    {
        return $batch->getObjectCollection('stack');
    }

    public function getPages(ObjectCollection $collection)
    {
        return $collection->getStacks();
    }
}
