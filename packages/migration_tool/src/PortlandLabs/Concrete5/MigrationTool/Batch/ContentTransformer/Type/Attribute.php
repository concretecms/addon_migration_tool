<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\ContentTransformer\Type;

use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\ItemInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\MapperInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentTransformer\TransformableEntityMapperInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentTransformer\TransformerInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\TargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\ImportedAttributeValue;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

/**
 * Class Attribute
 * This class is responsible for taking imported attribute values and transforming them based on their imported XML
 * into better data structures. This can't happen at import because we don't necessarily know the type of the attribute
 * being imported until after all the import is complete.
 *
 * @package PortlandLabs\Concrete5\MigrationTool\Batch\ContentTransformer\Type
 */
class Attribute implements TransformerInterface
{
    public function getUntransformedEntityObjects(TransformableEntityMapperInterface $mapper, BatchInterface $batch)
    {
        $results = array();
        foreach($mapper->getTransformableEntityObjects($batch) as $object) {
            $value = $object->getAttributeValue();
            if ($value instanceof ImportedAttributeValue) {
                $results[] = $value;
            }
        }

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

    public function getDriver()
    {
        return 'attribute';
    }

    public function transform($entity, MapperInterface $mapper, ItemInterface $item, TargetItem $targetItem, BatchInterface $batch)
    {
        $ak = $mapper->getTargetItemContentObject($targetItem);
        if (is_object($ak)) {
            $type = $ak->getAttributeType()->getAttributeTypeHandle();
        } else {
            $collection = $batch->getObjectCollection('attribute_key');
            if (is_object($collection)) {
                foreach ($collection->getKeys() as $key) {
                    if ($key->getHandle() == $item->getIdentifier()) {
                        $type = $key->getType();
                        break;
                    }
                }
            }
        }
        if (isset($type)) {
            $manager = \Core::make('migration/manager/import/attribute/value');
            try {
                $driver = $manager->driver($type);
            } catch (\Exception $e) {
            }
            if (isset($driver)) {
                $xml = simplexml_load_string($entity->getValue());
                $value = $driver->parse($xml);
                $attribute = $entity->getAttribute();
                $attribute->setAttributeValue($value);
                $manager = \Package::getByHandle('migration_tool')->getEntityManager();
                $manager->persist($attribute);
                $manager->remove($entity);
                $manager->flush();
            }
        }
    }
}
