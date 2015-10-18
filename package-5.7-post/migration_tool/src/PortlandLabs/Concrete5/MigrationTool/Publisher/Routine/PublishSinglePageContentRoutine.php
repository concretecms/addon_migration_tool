<?php

namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\MapperInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\TargetItemList;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\IgnoredTargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\UnmappedTargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

class PublishSinglePageContentRoutine extends PublishPageContentRoutine
{

    public function getPageCollection(Batch $batch)
    {
        return $batch->getObjectCollection('single_page');
    }

}
