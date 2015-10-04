<?php

namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use Concrete\Core\Attribute\Key\Category;
use Concrete\Core\Block\BlockType\BlockType;
use Concrete\Core\Page\Template;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

class CreateAttributeCategoriesRoutine implements RoutineInterface
{

    public function execute(Batch $batch)
    {

        $categories = $batch->getObjectCollection('attribute_key_category');
        foreach($categories->getCategories() as $category) {
            if (!$type->getPublisherValidator()->skipItem()) {
                $pkg = null;
                if ($category->getPackage()) {
                    $pkg = \Package::getByHandle($type->getPackage());
                }
                Category::add($category->getHandle(), $category->getAllowSets(), $pkg);
            }
        }
    }

}
