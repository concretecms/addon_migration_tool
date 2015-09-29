<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\ContentTransformer\Type;

use Concrete\Core\Attribute\Key\CollectionKey;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentTransformer\TransformerInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\TargetItem;

defined('C5_EXECUTE') or die("Access Denied.");

class Attribute implements TransformerInterface
{

    public function getUntransformedEntityObjects()
    {
        $em = \ORM::entityManager('migration_tool');
        $query = $em->createQuery('select v from \PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue v where v instance of \PortlandLabs\Concrete5\MigrationTool\Entity\Import\ImportedAttributeValue');
        $results = $query->getResult();
        return $results;
    }

    public function getItem($attribute_value)
    {
        if ($attribute_value && $attribute_value->getAttribute()) {
            $handle = $attribute_value->getAttribute()->getHandle();
            $item = new Item($handle);
            return $item;
        }
    }

    public function getMapper()
    {
        return new \PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\Attribute();
    }

    public function transform($entity, Item $item, TargetItem $targetItem)
    {
        $ak = CollectionKey::getByID($targetItem->getItemId());
        if (is_object($ak)) {
            $manager = \Core::make('migration/manager/import/attribute/value');
            $driver = $manager->driver($ak->getAttributeKeyType()->getAttributeTypeHandle());
            $xml = simplexml_load_string($entity->getValue());
            $value = $driver->parse($xml);
            $attribute = $entity->getAttribute();
            $attribute->setAttributeValue($value);
            $manager = \ORM::entityManager('migration_tools');
            $manager->persist($attribute);
            $manager->remove($entity);
            $manager->flush();
        }
    }



}