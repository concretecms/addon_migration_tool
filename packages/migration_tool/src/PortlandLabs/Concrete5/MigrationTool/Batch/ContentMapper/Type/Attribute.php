<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type;

use Concrete\Core\Attribute\Key\Category;
use Concrete\Core\Attribute\Key\CollectionKey;
use Concrete\Core\Attribute\Key\SiteKey;
use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentTransformer\TransformableEntityMapperInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\ShortDescriptionTargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageType\CollectionAttributeComposerFormLayoutSetControl;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\ItemInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\MapperInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\TargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\TargetItemInterface;

defined('C5_EXECUTE') or die("Access Denied.");

abstract class Attribute implements MapperInterface, TransformableEntityMapperInterface
{

    abstract public function getAttributeKeyCategoryHandle();
    public function getAttributeItemHandles(BatchInterface $batch)
    {
        $handles = array();
        $attributes = $this->getTransformableEntityObjects($batch);
        foreach ($attributes as $attribute) {
            if (!in_array($attribute->getHandle(), $handles)) {
                $handles[] = $attribute->getHandle();
            }
        }
        return $handles;
    }

    public function getItems(BatchInterface $batch)
    {
        $handles = $this->getAttributeItemHandles($batch);
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
        $controller = Category::getByHandle($this->getAttributeKeyCategoryHandle())
            ->getController();
        $ak = $controller->getByHandle($item->getIdentifier());

        if (is_object($ak)) {
            $targetItem = new TargetItem($this);
            $targetItem->setItemId($ak->getAttributeKeyHandle());
            $targetItem->setItemName($ak->getAttributeKeyDisplayName());
            return $targetItem;
        } else { // we check the current batch.
            $collection = $batch->getObjectCollection('attribute_key');
            if (is_object($collection)) {
                foreach ($collection->getKeys() as $key) {
                    $category = $key->getCategory();
                    if ($category == $this->getAttributeKeyCategoryHandle()) {
                        if ($key->getHandle() == $item->getIdentifier()) {
                            $targetItem = new TargetItem($this);
                            $targetItem->setItemId($key->getHandle());
                            $targetItem->setItemName($key->getHandle());
                            return $targetItem;
                        }
                    }
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

    public function getCorePropertyTargetItems(BatchInterface $batch)
    {
        return array();
    }

    public function getInstalledTargetItems(BatchInterface $batch)
    {
        $controller = Category::getByHandle($this->getAttributeKeyCategoryHandle())
            ->getController();
        $keys = $controller->getList();
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
        $controller = Category::getByHandle($this->getAttributeKeyCategoryHandle())
            ->getController();
        return $controller->getByHandle($targetItem->getItemID());
    }
}
