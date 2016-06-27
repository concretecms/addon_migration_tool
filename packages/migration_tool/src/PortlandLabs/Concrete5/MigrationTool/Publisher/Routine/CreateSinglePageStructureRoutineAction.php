<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use Concrete\Core\Page\Single;
use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

class CreateSinglePageStructureRoutineAction extends AbstractPageAction
{

    public function execute(BatchInterface $batch)
    {
        $pkg = null;
        $page = $this->page;
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
