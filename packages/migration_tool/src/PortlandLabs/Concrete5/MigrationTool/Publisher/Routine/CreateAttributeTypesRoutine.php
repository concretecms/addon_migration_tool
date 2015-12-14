<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use Concrete\Core\Attribute\Key\Category;
use Concrete\Core\Attribute\Type;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

class CreateAttributeTypesRoutine implements RoutineInterface
{
    public function execute(Batch $batch)
    {
        $types = $batch->getObjectCollection('attribute_key_category');

        if (!$types) {
            return;
        }

        foreach ($types->getCategories() as $type) {
            if (!$type->getPublisherValidator()->skipItem()) {
                $pkg = null;
                if ($type->getPackage()) {
                    $pkg = \Package::getByHandle($type->getPackage());
                }
                $type = Type::add($type->getHandle(), $type->getName(), $pkg);
                $categories = $type->getCategories();
                foreach ($categories as $category) {
                    $co = Category::getByHandle($category);
                    if (is_object($co)) {
                        $co->associateAttributeKeyType($type);
                    }
                }
            }
        }
    }
}
