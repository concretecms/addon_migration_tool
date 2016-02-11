<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use Concrete\Core\Page\Stack\Stack;
use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\ObjectCollection;

defined('C5_EXECUTE') or die("Access Denied.");

class CreateStackStructureRoutine extends AbstractPageRoutine
{
    public function getPageCollection(BatchInterface $batch)
    {
        return $batch->getObjectCollection('stack');
    }

    public function getPages(ObjectCollection $collection)
    {
        return $collection->getStacks();
    }

    public function execute(BatchInterface $batch)
    {
        $this->batch = $batch;

        $stacks = $this->getPagesOrderedForImport($batch);

        if (!$stacks) {
            return;
        }
        foreach($stacks as $stack) {

            if (!$stack->getPublisherValidator()->skipItem()) {

                $parent = null;
                if ($stack->getPath() != '') {
                    $lastSlash = strrpos($stack->getPath(), '/');
                    $parentPath = substr($stack->getPath(), 0, $lastSlash);
                    if ($parentPath) {
                        $parent = \Concrete\Core\Support\Facade\StackFolder::getByPath($parentPath);
                    }
                }

                switch($stack->getType()) {
                    case 'folder':
                        $folder = \Concrete\Core\Support\Facade\StackFolder::getByPath($stack->getName());
                        if (!is_object($folder)) {
                            \Concrete\Core\Support\Facade\StackFolder::add($stack->getName(), $parent);
                        }
                        break;
                    case 'global_area':
                        $s = Stack::getByName($stack->getName());
                        if (!is_object($s)) {
                            if (method_exists('\Concrete\Core\Page\Stack\Stack', 'addGlobalArea')) {
                                Stack::addGlobalArea($stack->getName());
                            } else {
                                //legacy
                                Stack::addStack($stack->getName(), 'global_area');
                            }
                        }
                        break;
                    default:
                        //stack
                        if (method_exists('\Concrete\Core\Page\Stack\Stack', 'getByPath')) {
                            $s = Stack::getByPath($stack->getPath());
                            if (!is_object($s)) {
                                Stack::addStack($stack->getName(), $parent);
                            }
                        } else {
                            $s = Stack::getByName($stack->getName());
                            if (!is_object($s)) {
                                // legacy, so no folder support
                                Stack::addStack($stack->getName());
                            }
                        }
                        break;
                }
            }
        }
    }
}
