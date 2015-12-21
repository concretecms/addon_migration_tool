<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\ContentTransformer\Type;

use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\BlockItem;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\ItemInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentTransformer\TransformerInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\TargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

class BlockType implements TransformerInterface
{
    public function getUntransformedEntityObjects()
    {
        $em = \ORM::entityManager('migration_tool');
        $query = $em->createQuery('select v from \PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue\BlockValue v where v instance of \PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue\ImportedBlockValue');
        $results = $query->getResult();

        return $results;
    }

    public function getItem($block_value)
    {
        if ($block_value && $block_value->getBlock()) {
            $block = $block_value->getBlock();
            $item = new BlockItem($block);

            return $item;
        }
    }

    public function getMapper()
    {
        return new \PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\BlockType();
    }

    public function transform($entity, ItemInterface $item, TargetItem $targetItem, Batch $batch)
    {
        $mapper = new \PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\BlockType();
        $bt = $mapper->getTargetItemContentObject($targetItem);
        if (is_object($bt)) {
            $type = $bt->getBlockTypeHandle();
        } else {
            $collection = $batch->getObjectCollection('block_type');
            foreach ($collection->getTypes() as $blockType) {
                if ($blockType->getHandle() == $item->getIdentifier()) {
                    $type = $blockType->getType();
                    break;
                }
            }
        }

        if (isset($type)) {
            $manager = \Core::make('migration/manager/import/cif_block');
            try {
                $driver = $manager->driver($type);
            } catch (\Exception $e) {
            }

            if (isset($driver)) {
                $value = null;
                if ($entity->getValue()) {
                    $xml = simplexml_load_string($entity->getValue());
                    $value = $driver->parse($xml);
                }
                $block = $entity->getBlock();
                $block->setBlockValue($value);
                $manager = \ORM::entityManager('migration_tools');
                $manager->persist($block);
                $manager->remove($entity);
                $manager->flush();
            }
        }
    }
}
