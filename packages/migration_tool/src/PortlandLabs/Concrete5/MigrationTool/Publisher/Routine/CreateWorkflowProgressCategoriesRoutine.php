<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

class CreateWorkflowProgressCategoriesRoutine implements RoutineInterface
{
    public function execute(Batch $batch)
    {
        $types = $batch->getObjectCollection('workflow_progress_category');

        if (!$types) {
            return;
        }

        foreach ($types->getCategories() as $category) {
            if (!$category->getPublisherValidator()->skipItem()) {
                $pkg = null;
                if ($category->getPackage()) {
                    $pkg = \Package::getByHandle($category->getPackage());
                }
                \Concrete\Core\Workflow\Progress\Category::add($category->getHandle(), $pkg);
            }
        }
    }
}
