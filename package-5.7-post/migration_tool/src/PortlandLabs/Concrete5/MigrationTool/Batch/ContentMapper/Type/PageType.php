<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type;

use Concrete\Core\Page\Type\Type;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\ItemInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\MapperInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\TargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

class PageType implements MapperInterface
{

    public function getMappedItemPluralName()
    {
        return t('Page Types');
    }

    public function getHandle()
    {
        return 'page_type';
    }

    public function getItems(Batch $batch)
    {
        $types = array();
        foreach($batch->getPages() as $page) {
            if ($page->getType() && !in_array($page->getType(), $types)) {
                $types[] = $page->getType();
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

    public function getMatchedTargetItem(ItemInterface $item)
    {
        $type = Type::getByHandle($item->getIdentifier());
        if (is_object($type)) {
            $targetItem = new TargetItem($this);
            $targetItem->setItemId($type->getPageTypeID());
            $targetItem->setItemName($type->getPageTypeDisplayName());
            return $targetItem;
        }
    }

    public function getTargetItems(Batch $batch)
    {
        $types = Type::getList();
        usort($types, function($a, $b) {
            return strcasecmp($a->getPageTypeName(), $b->getPageTypeName());
        });
        $items = array();
        foreach($types as $type) {
            $item = new TargetItem($this);
            $item->setItemId($type->getPageTypeID());
            $item->setItemName($type->getPageTypeDisplayName());
            $items[] = $item;
        }
        return $items;
    }



}