<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type;

use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\MapperInterface;
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

    public function getTargetItems()
    {
        return array();
    }


}