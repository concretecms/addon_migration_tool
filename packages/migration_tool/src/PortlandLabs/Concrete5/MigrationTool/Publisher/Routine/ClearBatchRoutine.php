<?php

namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die('Access Denied.');

class ClearBatchRoutine extends AbstractRoutine
{
    public function execute(BatchInterface $batch)
    {
        // Has the batch already been created? If so, we move to trash.
        $orphaned = \Page::getByPath('/!import_batches/'.$batch->getID());
        if (is_object($orphaned) && !$orphaned->isError()) {
            $orphaned->moveToTrash();
        }
    }
}
