<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use Concrete\Core\Page\Single;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

class CreateSinglePageStructureRoutine extends AbstractPageRoutine
{
    public function getPageCollection(Batch $batch)
    {
        return $batch->getObjectCollection('single_page');
    }

    public function execute(Batch $batch)
    {
        $this->batch = $batch;

        // Now loop through all pages, and build them
        foreach ($this->getPagesOrderedForImport($batch) as $page) {
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
