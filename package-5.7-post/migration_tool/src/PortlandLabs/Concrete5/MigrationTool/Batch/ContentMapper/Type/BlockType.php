<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type;

use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\ItemInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\MapperInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\TargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\TargetItemInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageType\BlockComposerFormLayoutSetControl;

defined('C5_EXECUTE') or die("Access Denied.");

class BlockType implements MapperInterface
{

    public function getMappedItemPluralName()
    {
        return t('Block Types');
    }

    public function getHandle()
    {
        return 'block_type';
    }

    public function getItems(Batch $batch)
    {
        $types = array();
        foreach($batch->getPages() as $page) {
            foreach($page->getAreas() as $area) {
                foreach($area->getBlocks() as $block) {
                    if (!in_array($block->getType(), $types)) {
                        $types[] = $block->getType();
                    }
                }
            }
        }
        $stacks = $batch->getObjectCollection('stack');
        foreach($stacks->getStacks() as $stack) {
            $blocks = $stack->getBlocks();
            foreach($blocks as $block) {
                $types[] = $block->getType();
            }
        }

        $pageTypes = $batch->getObjectCollection('page_type');
        foreach($pageTypes->getTypes() as $type) {
            foreach($type->getLayoutSets() as $set) {
                foreach($set->getControls() as $control) {
                    if ($control instanceof BlockComposerFormLayoutSetControl) {
                        if (!in_array($control->getItemIdentifier(), $types)) {
                            $types[] = $control->getItemIdentifier();
                        }
                    }
                }
            }
            $defaults = $type->getDefaultPageCollection();
            foreach($defaults->getPages() as $page) {
                foreach($page->getAreas() as $area) {
                    foreach($area->getBlocks() as $block) {
                        if (!in_array($block->getType(), $types)) {
                            $types[] = $block->getType();
                        }
                    }
                }
            }
        }

        $items = array();
        foreach($types as $type) {
            $item = new Item();
            $item->setIdentifier($type);
            $items[] = $item;
        }
        return $items;
    }

    public function getMatchedTargetItem(Batch $batch, ItemInterface $item)
    {
        $bt = \Concrete\Core\Block\BlockType\BlockType::getByHandle($item->getIdentifier());
        if (is_object($bt)) {
            $targetItem = new TargetItem($this);
            $targetItem->setItemId($bt->getBlockTypeID());
            $targetItem->setItemName($bt->getBlockTypeName());
            return $targetItem;
        } else { // we check the current batch.
            $collection = $batch->getObjectCollection('block_type');
            foreach($collection->getTypes() as $type) {
                if ($type->getHandle() == $item->getIdentifier()) {
                    $targetItem = new TargetItem($this);
                    $targetItem->setItemId($type->getHandle());
                    $targetItem->setItemName($type->getHandle());
                    return $targetItem;
                }
            }
        }
    }

    public function getBatchTargetItems(Batch $batch)
    {
        $collection = $batch->getObjectCollection('block_type');
        $items = array();
        foreach($collection->getTypes() as $type) {
            if (!$type->getPublisherValidator()->skipItem()) {
                $item = new TargetItem($this);
                $item->setItemId($type->getHandle());
                $item->setItemName($type->getHandle());
                $items[] = $item;
            }
        }
        return $items;
    }

    public function getInstalledTargetItems(Batch $batch)
    {
        $types = \Concrete\Core\Block\BlockType\BlockTypeList::getInstalledList();
        usort($types, function($a, $b) {
            return strcasecmp($a->getBlockTypeName(), $b->getBlockTypeName());
        });
        $items = array();
        foreach($types as $type) {
            $item = new TargetItem($this);
            $item->setItemId($type->getBlockTypeID());
            $item->setItemName($type->getBlockTypeName());
            $items[] = $item;
        }
        return $items;
    }

    public function getTargetItemContentObject(TargetItemInterface $targetItem)
    {
        return \Concrete\Core\Block\BlockType\BlockType::getByID($targetItem->getItemID());
    }
}