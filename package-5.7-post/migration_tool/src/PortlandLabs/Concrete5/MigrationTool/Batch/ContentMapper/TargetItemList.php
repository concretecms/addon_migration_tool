<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper;

use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\IgnoredTargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\UnmappedTargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\ItemInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class TargetItemList
{

    protected $mapper;

    public function __construct(Batch $batch, MapperInterface $mapper)
    {
        $this->mapper = $mapper;
        $this->batch = $batch;
        $this->entityManager = \Package::getByHandle('migration_tool')->getEntityManager();
    }

    public function getMapperTargetItems()
    {
        return $this->mapper->getTargetItems($this->batch);
    }

    public function getInternalTargetItems()
    {
        return array(
            new UnmappedTargetItem($this->mapper),
            new IgnoredTargetItem($this->mapper)
        );
    }

    public function getMatchedTargetItem(ItemInterface $item)
    {
        $targetItem = $this->mapper->getMatchedTargetItem($item);
        if (!is_object($targetItem)) {
            $targetItem = new UnmappedTargetItem($this->mapper);
        }
        $targetItem->setSourceItemIdentifier($item->getIdentifier());
        return $targetItem;
    }

    public function getSelectedTargetItem(ItemInterface $item)
    {
        $query = $this->entityManager->createQuery(
            "select ti from PortlandLabs\Concrete5\MigrationTool\Entity\Import\BatchTargetItem bti
            join PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\TargetItem ti
            where bti.batch = :batch and ti.item_type = :type and ti.source_item_identifier = :source_item_identifier"
        );
        $query->setParameter('batch', $this->batch);
        $query->setParameter('source_item_identifier', $item->getIdentifier());
        $query->setParameter('type', $this->mapper->getHandle());
        $targetItem = $query->getResult();
        return $targetItem[0];
    }

    public function getTargetItem($identifier)
    {
        $items = array_merge($this->getMapperTargetItems(), $this->getInternalTargetItems());
        $item = false;
        foreach($items as $item) {
            if ($item->getItemID() == $identifier) {
                break;
            }
        }
        return $item;
    }
}
