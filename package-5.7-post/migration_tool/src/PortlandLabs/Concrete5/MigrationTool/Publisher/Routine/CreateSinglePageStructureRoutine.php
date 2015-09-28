<?php

namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use Concrete\Core\Page\Single;
use Concrete\Core\Page\Type\Type;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\MapperInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\TargetItemList;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\IgnoredTargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\UnmappedTargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

class CreateSinglePageStructureRoutine extends AbstractPageRoutine
{
    public function execute(Batch $batch)
    {
        $this->batch = $batch;

        // Now loop through all pages, and build them
        foreach($this->getPagesOrderedForImport($batch->getObjectCollection('single_page')) as $page) {

            $pkg = null;
            if ($page->getPackage()) {
                $pkg = \Package::getByHandle($page->getPackage());
            }

            $c = Single::add($page->getOriginalPath(), $pkg);
            if (is_object($c)) {
                if ($page->getIsAtRoot()) {
                    $c->moveToRoot();
                }

                $data['name'] = $page->getName();
                $data['description'] = $page->getDescription();
                $c->update($data);
            }
        }

    }

}
