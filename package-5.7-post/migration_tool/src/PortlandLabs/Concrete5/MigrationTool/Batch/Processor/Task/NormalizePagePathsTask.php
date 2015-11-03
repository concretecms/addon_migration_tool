<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Processor\Task;

use Concrete\Core\Foundation\Processor\ActionInterface;
use Concrete\Core\Foundation\Processor\TaskInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class NormalizePagePathsTask implements TaskInterface
{

    protected $paths = array();

    public function execute(ActionInterface $action)
    {
        $subject = $action->getSubject();
        $path = trim($subject->getOriginalPath(), '/');
        $this->paths[] = $path;
    }

    public function finish(ActionInterface $action)
    {
        $target = $action->getTarget();
        $pl = 0;
        $n = count($this->paths);
        $l = strlen($this->paths[0]);
        while ($pl < $l) {
            $c = $this->paths[0][$pl];
            for ($i = 1; $i < $n; $i++) {
                if ($this->paths[$i][$pl] !== $c) break 2;
            }
            $pl++;
        }
        $common = substr($this->paths[0], 0, $pl);
        $pages = $target->getBatch()->getPages();
        if ($common && count($pages) > 1) {
            $common = '/' . trim($common, '/');
            foreach($pages as $page) {
                $newPath = substr($page->getOriginalPath(), strlen($common));
                $page->setBatchPath($newPath);
            }
        } else {
            foreach($pages as $page) {
                $page->setBatchPath($page->getOriginalPath());
            }
        }
    }

}
