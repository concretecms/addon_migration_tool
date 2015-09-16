<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Processor\Task;

use Concrete\Core\Foundation\Processor\TargetInterface;
use Concrete\Core\Foundation\Processor\TaskInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class NormalizePagePathsTask implements TaskInterface
{

    protected $paths = array();

    public function execute(TargetInterface $target, $subject)
    {
        $path = trim($subject->getOriginalPath(), '/');
        $this->paths[] = $path;
    }

    public function finish(TargetInterface $target)
    {
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
        if ($common) {
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
