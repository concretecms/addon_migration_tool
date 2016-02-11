<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type;

use Concrete\Core\Attribute\Key\CollectionKey;
use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageType\CollectionAttributeComposerFormLayoutSetControl;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\ItemInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\MapperInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\TargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\TargetItemInterface;

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

    public function getItems(BatchInterface $batch)
    {
        $handles = array();
        foreach ($batch->getPages() as $page) {
            foreach ($page->getAttributes() as $attribute) {
                if (!in_array($attribute->getAttribute()->getHandle(), $handles)) {
                    $handles[] = $attribute->getAttribute()->getHandle();
                }
            }
        }

        $pageTypes = $batch->getObjectCollection('page_type');
        if (is_object($pageTypes)) {
            foreach ($pageTypes->getTypes() as $type) {
                foreach ($type->getLayoutSets() as $set) {
                    foreach ($set->getControls() as $control) {
                        if ($control instanceof CollectionAttributeComposerFormLayoutSetControl) {
                            if (!in_array($control->getItemIdentifier(), $handles)) {
                                $handles[] = $control->getItemIdentifier();
                            }
                        }
                    }
                }
                $defaults = $type->getDefaultPageCollection();
                foreach ($defaults->getPages() as $page) {
                    foreach ($page->getAttributes() as $attribute) {
                        if (!in_array($attribute->getAttribute()->getHandle(), $handles)) {
                            $handles[] = $attribute->getAttribute()->getHandle();
                        }
                    }
                }
            }
        }

        $items = array();
        foreach ($handles as $handle) {
            $item = new Item();
            $item->setIdentifier($handle);
            $items[] = $item;
        }

        return $items;
    }

    public function getMatchedTargetItem(BatchInterface $batch, ItemInterface $item)
    {
        $ak = CollectionKey::getByHandle($item->getIdentifier());
        if (is_object($ak)) {
            $targetItem = new TargetItem($this);
            $targetItem->setItemId($ak->getAttributeKeyHandle());
            $targetItem->setItemName($ak->getAttributeKeyDisplayName());

            return $targetItem;
        } else { // we check the current batch.
            $collection = $batch->getObjectCollection('attribute_key');
            foreach ($collection->getKeys() as $key) {
                if ($key->getHandle() == $item->getIdentifier()) {
                    $targetItem = new TargetItem($this);
                    $targetItem->setItemId($key->getHandle());
                    $targetItem->setItemName($key->getHandle());

                    return $targetItem;
                }
            }
        }
    }

    public function getBatchTargetItems(BatchInterface $batch)
    {
        $collection = $batch->getObjectCollection('attribute_key');
        $items = array();
        if ($collection) {
            foreach ($collection->getKeys() as $key) {
                if (!$key->getPublisherValidator()->skipItem()) {
                    $item = new TargetItem($this);
                    $item->setItemId($key->getHandle());
                    $item->setItemName($key->getHandle());
                    $items[] = $item;
                }
            }
        }

        return $items;
    }

    public function getInstalledTargetItems(BatchInterface $batch)
    {
        $keys = CollectionKey::getList();
        usort($keys, function ($a, $b) {
            return strcasecmp($a->getAttributeKeyName(), $b->getAttributeKeyName());
        });
        $items = array();
        foreach ($keys as $ak) {
            $item = new TargetItem($this);
            $item->setItemId($ak->getAttributeKeyHandle());
            $item->setItemName($ak->getAttributeKeyDisplayName());
            $items[] = $item;
        }

        return $items;
    }

    public function getTargetItemContentObject(TargetItemInterface $targetItem)
    {
        return CollectionKey::getByHandle($targetItem->getItemID());
    }
}
