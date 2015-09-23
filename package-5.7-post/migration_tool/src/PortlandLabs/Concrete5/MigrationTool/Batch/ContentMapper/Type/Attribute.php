<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type;

use Concrete\Core\Attribute\Key\CollectionKey;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\ItemInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\MapperInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\TargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\TargetItemInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

class Attribute implements MapperInterface
{

    public function getMappedItemPluralName()
    {
        return t('Attributes');
    }

    public function getHandle()
    {
        return 'attribute';
    }

    public function getItems(Batch $batch)
    {
        $handles = array();
        foreach($batch->getPages() as $page) {
            foreach($page->getAttributes() as $attribute) {
                if (!in_array($attribute->getAttribute()->getHandle(), $handles)) {
                    $handles[] = $attribute->getAttribute()->getHandle();
                }
            }
        }
        $items = array();
        foreach($handles as $handle) {
            $item = new Item();
            $item->setIdentifier($handle);
            $items[] = $item;
        }
        return $items;
    }

    public function getMatchedTargetItem(ItemInterface $item)
    {
        $ak = CollectionKey::getByHandle($item->getIdentifier());
        if (is_object($ak)) {
            $targetItem = new TargetItem($this);
            $targetItem->setItemId($ak->getAttributeKeyID());
            $targetItem->setItemName($ak->getAttributeKeyDisplayName());
            return $targetItem;
        }
    }

    public function getTargetItems(Batch $batch)
    {
        $keys = CollectionKey::getList();
        usort($keys, function($a, $b) {
            return strcasecmp($a->getAttributeKeyName(), $b->getAttributeKeyName());
        });
        $items = array();
        foreach($keys as $ak) {
            $item = new TargetItem($this);
            $item->setItemId($ak->getAttributeKeyID());
            $item->setItemName($ak->getAttributeKeyDisplayName());
            $items[] = $item;
        }
        return $items;
    }

    public function getTargetItemContentObject(TargetItemInterface $targetItem)
    {
        return CollectionKey::getByID($targetItem->getItemID());
    }



}