<?php

namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use Concrete\Core\Permission\Category;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

class CreatePermissionCategoriesRoutine implements RoutineInterface
{

    public function execute(Batch $batch)
    {
        $categories = $batch->getObjectCollection('permission_category');
        foreach($categories->getCategories() as $category) {
            if (!$category->getPublisherValidator()->skipItem()) {
                $pkg = null;
                if ($category->getPackage()) {
                    $pkg = \Package::getByHandle($category->getPackage());
                }
                Category::add($category->getHandle(), $pkg);
            }
        }
    }

}
