<?php

namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use Concrete\Core\Page\Single;
use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;

defined('C5_EXECUTE') or die('Access Denied.');

class CreateSinglePageStructureRoutineAction extends AbstractPageAction
{
    public function execute(BatchInterface $batch)
    {
        $pkg = null;
        $page = $this->page;
        if ($page->getPackage()) {
            $pkg = \Package::getByHandle($page->getPackage());
        }

        if (compat_is_version_8()) {
            if ($page->getIsGlobal()) {
                $c = Single::addGlobal($page->getOriginalPath(), $pkg);
            } else {
                $home = \Page::getByID(HOME_CID);
                $siteTree = $home->getSiteTreeObject();
                $c = Single::createPageInTree($page->getOriginalPath(), $siteTree, $page->getIsAtRoot(), $pkg);
            }
        } else {
            $c = Single::add($page->getOriginalPath(), $pkg);
            if (is_object($c)) {
                if ($page->getIsAtRoot()) {
                    $c->moveToRoot();
                }
            }
        }

        if (is_object($c)) {
            $data['name'] = $page->getName();
            $data['description'] = $page->getDescription();
            $c->update($data);
        }
    }
}
