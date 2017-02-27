<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper;

use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\IgnoredTargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\UnmappedTargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\ItemInterface;

defined('C5_EXECUTE') or die('Access Denied.');

class TargetItemList
{
    protected $mapper;
    protected $repository;

    public function __construct(BatchInterface $batch, MapperInterface $mapper)
    {
        $this->mapper = $mapper;
        $this->batch = $batch;
        $this->entityManager = \Package::getByHandle('migration_tool')->getEntityManager();
        $this->repository = 'PortlandLabs\Concrete5\MigrationTool\Entity\Import\BatchTargetItem';
    }

    public function getMapperCorePropertyTargetItems()
    {
        return $this->mapper->getCorePropertyTargetItems($this->batch);
    }

    public function getMapperInstalledTargetItems()
    {
        return $this->mapper->getInstalledTargetItems($this->batch);
    }

    public function getMapperBatchTargetItems()
    {
        return $this->mapper->getBatchTargetItems($this->batch);
    }

    /**
     * @return mixed
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * @param mixed $repository
     */
    public function setRepository($repository)
    {
        $this->repository = $repository;
    }

    public function getInternalTargetItems()
    {
        return array(
            new UnmappedTargetItem($this->mapper),
            new IgnoredTargetItem($this->mapper),
        );
    }

    public function getMatchedTargetItem(ItemInterface $item)
    {
        $targetItem = $this->mapper->getMatchedTargetItem($this->batch, $item);
        if (!is_object($targetItem)) {
            $targetItem = new UnmappedTargetItem($this->mapper);
        }
        $targetItem->setSourceItemIdentifier($item->getIdentifier());

        return $targetItem;
    }

    public function getSelectedTargetItem(ItemInterface $item)
    {
        $query = $this->entityManager->createQuery(
            "select ti from {$this->repository} bti
            join PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\TargetItem ti
            where bti.batch = :batch and bti.target_item = ti and ti.item_type = :type and ti.source_item_identifier = :source_item_identifier"
        );
        $query->setParameter('batch', $this->batch);
        $query->setParameter('source_item_identifier', $item->getIdentifier());
        $query->setParameter('type', $this->mapper->getHandle());
        $targetItem = $query->getResult();
        if (!is_object($targetItem[0])) {
            return new UnmappedTargetItem($this->mapper);
        }

        return $targetItem[0];
    }

    public function getTargetItem($identifier)
    {
        $items = array_merge(
            $this->getMapperBatchTargetItems(),
            $this->getMapperCorePropertyTargetItems(),
            $this->getMapperInstalledTargetItems(),
            $this->getInternalTargetItems());
        $item = false;
        foreach ($items as $item) {
            if ($item->getItemID() == $identifier) {
                break;
            }
        }

        return $item;
    }
}
