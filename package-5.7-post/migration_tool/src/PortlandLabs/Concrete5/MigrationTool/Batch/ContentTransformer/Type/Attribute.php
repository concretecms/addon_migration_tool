<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\ContentTransformer\Type;

use Concrete\Core\Attribute\Key\CollectionKey;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\ItemInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentTransformer\TransformerInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\TargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

/**
 * Class Attribute
 * This class is responsible for taking imported attribute values and transforming them based on their imported XML
 * into better data structures. This can't happen at import because we don't necessarily know the type of the attribute
 * being imported until after all the import is complete.
 * @package PortlandLabs\Concrete5\MigrationTool\Batch\ContentTransformer\Type
 */
class Attribute implements TransformerInterface
{

    public function getUntransformedEntityObjects()
    {
        $em = \ORM::entityManager('migration_tool');
        $query = $em->createQuery('select v from \PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\AttributeValue v where v instance of \PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\ImportedAttributeValue');
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

    public function transform($entity, ItemInterface $item, TargetItem $targetItem, Batch $batch)
    {
        $mapper = new \PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\Attribute();
        $ak = $mapper->getTargetItemContentObject($targetItem);
        if (is_object($ak)) {
            $type = $ak->getAttributeKeyType()->getAttributeTypeHandle();
        } else {
            $collection = $batch->getObjectCollection('attribute_key');
            foreach($collection->getKeys() as $key) {
                if ($key->getHandle() == $item->getIdentifier()) {
                    $type = $key->getType();
                    break;
                }
            }
        }
        if (isset($type)) {
            $manager = \Core::make('migration/manager/import/attribute/value');
            try {
                $driver = $manager->driver($type);
            } catch(\Exception $e) {

            }
            if (isset($driver)) {
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



}