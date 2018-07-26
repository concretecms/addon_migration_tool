<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\ObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\LoggerInterface;

defined('C5_EXECUTE') or die("Access Denied.");

abstract class AbstractPageRoutine implements RoutineInterface
{
    protected $batch;

    abstract public function getPageRoutineCommand(BatchInterface $batch, LoggerInterface $logger, $pageId);

    public function getPageCollection(BatchInterface $batch)
    {
        return $batch->getObjectCollection('page');
    }

    public function getPages(ObjectCollection $collection)
    {
        return $collection->getPages();
    }

    public function getPagesOrderedForImport(Batch $batch)
    {
        $collection = $this->getPageCollection($batch);

        if (!$collection) {
            return array();
        }

        $pages = array();
        foreach ($this->getPages($collection) as $page) {
            $pages[] = $page;
        }
        usort($pages, function ($pageA, $pageB) {
            $pathA = (string) $pageA->getBatchPath();
            $pathB = (string) $pageB->getBatchPath();
            $numA = count(explode('/', $pathA));
            $numB = count(explode('/', $pathB));
            if ($numA == $numB) {
                if (intval($pageA->getPosition()) < intval($pageB->getPosition())) {
                    return -1;
                } else {
                    if (intval($pageA->getPosition()) > intval($pageB->getPosition())) {
                        return 1;
                    } else {
                        return 0;
                    }
                }
            } else {
                return ($numA < $numB) ? -1 : 1;
            }
        });

        return $pages;
    }

    public function getPublisherCommands(BatchInterface $batch, LoggerInterface $logger)
    {
        $pages = $this->getPagesOrderedForImport($batch);

        if (!$pages) {
            return array();
        }

        // Now loop through all pages, and build them
        $actions = array();
        foreach ($pages as $page) {
            if (!$page->getPublisherValidator()->skipItem()) {
                $action = $this->getPageRoutineCommand($batch, $logger, $page->getId());
                $actions[] = $action;
            }
        }

        return $actions;
    }
}
