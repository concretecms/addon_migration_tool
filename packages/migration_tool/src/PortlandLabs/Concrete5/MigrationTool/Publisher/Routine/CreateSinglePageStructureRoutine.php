<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use Concrete\Core\Page\Single;
use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

class CreateSinglePageStructureRoutine extends AbstractPageRoutine
{
    public function getPageCollection(BatchInterface $batch)
    {
        return $batch->getObjectCollection('single_page');
    }

    public function getPageRoutineAction($page)
    {
        return new CreateSinglePageStructureRoutineAction($page);
    }

}
