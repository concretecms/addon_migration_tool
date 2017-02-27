<?php

namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use Concrete\Core\Attribute\Key\Category;
use Concrete\Core\Attribute\Type;
use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;

defined('C5_EXECUTE') or die('Access Denied.');

class CreateAttributeTypesRoutine extends AbstractRoutine
{
    public function execute(BatchInterface $batch)
    {
        $types = $batch->getObjectCollection('attribute_type');

        if (!$types) {
            return;
        }

        foreach ($types->getTypes() as $type) {
            if (!$type->getPublisherValidator()->skipItem()) {
                $pkg = null;
                if ($type->getPackage()) {
                    $pkg = \Package::getByHandle($type->getPackage());
                }
                $attributeType = Type::add($type->getHandle(), $type->getName(), $pkg);
                $categories = $type->getCategories();
                foreach ($categories as $category) {
                    $co = Category::getByHandle($category);
                    if (is_object($co)) {
                        $co->associateAttributeKeyType($attributeType);
                    }
                }
            }
        }
    }
}
