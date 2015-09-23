<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\ContentTransformer\Type;

use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentTransformer\TransformerInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\TargetItem;
use Concrete\Core\Block\BlockType\BlockType as CoreBlockType;

defined('C5_EXECUTE') or die("Access Denied.");

class BlockType implements TransformerInterface
{

    public function getUntransformedEntityObjects()
    {
        $em = \ORM::entityManager('migration_tool');
        $query = $em->createQuery('select v from \PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue v where v instance of \PortlandLabs\Concrete5\MigrationTool\Entity\Import\ImportedBlockValue');
        $results = $query->getResult();
        return $results;
    }

    public function getItem($block_value)
    {
        if ($block_value && $block_value->getBlock()) {
            $handle = $block_value->getBlock()->getType();
            $item = new Item($handle);
            return $item;
        }
    }

    public function getMapper()
    {
        return new \PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\BlockType();
    }

    public function transform($entity, Item $item, TargetItem $targetItem)
    {
        $bt = CoreBlockType::getByID($targetItem->getItemId());
        if (is_object($bt)) {
            $manager = \Core::make('migration/manager/import/block');
            $driver = $manager->driver($bt->getBlockTypeHandle());
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