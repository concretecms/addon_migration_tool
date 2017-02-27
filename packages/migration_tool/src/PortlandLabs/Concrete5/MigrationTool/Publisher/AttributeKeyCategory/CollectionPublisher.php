<?php

namespace PortlandLabs\Concrete5\MigrationTool\Publisher\AttributeKeyCategory;

use Concrete\Core\Attribute\Key\CollectionKey;
use Concrete\Core\Attribute\Key\Category;
use Concrete\Core\Package\Package;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKey;

defined('C5_EXECUTE') or die('Access Denied.');

class CollectionPublisher implements PublisherInterface
{
    public function publish(AttributeKey $ak, Package $pkg = null)
    {
        $category = $ak->getCategory();
        $category = Category::getByHandle($category);
        if (interface_exists('\Concrete\Core\Attribute\EntityInterface') &&
            $category instanceof \Concrete\Core\Attribute\EntityInterface) {
            // Version 8
            $key = new \Concrete\Core\Entity\Attribute\Key\PageKey();
            $key->setAttributeKeyHandle($ak->getHandle());
            $key->setAttributeKeyName($ak->getName());
            $key->setIsAttributeKeyInternal($ak->getIsInternal());
            $key->setIsAttributeKeyContentIndexed($ak->getIsIndexed());
            $key->setIsAttributeKeySearchable($ak->getIsSearchable());
        } else {
            $key = CollectionKey::add($ak->getType(),
                array(
                    'akHandle' => $ak->getHandle(),
                    'akName' => $ak->getName(),
                    'akIsInternal' => $ak->getIsInternal(),
                    'akIsSearchableIndexed' => $ak->getIsIndexed(),
                    'akIsSearchable' => $ak->getIsSearchable(),
                ), $pkg);
        }

        return $key;
    }
}
