<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Processor\Task;

use Concrete\Core\Foundation\Processor\ActionInterface;
use Concrete\Core\Foundation\Processor\TaskInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\MapperManagerInterface;

defined('C5_EXECUTE') or die('Access Denied.');

class MapContentTypesTask implements TaskInterface
{
    protected $mappers;

    public function __construct(MapperManagerInterface $mappers)
    {
        $this->mappers = $mappers;
    }

    public function execute(ActionInterface $action)
    {
        $target = $action->getTarget();
        $subject = $action->getSubject();
        $batch = $target->getBatch();

        // Since batch is serialized we do this:
        $em = \Database::connection()->getEntityManager();
        $batch = $em->getRepository('PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch')->findOneById($batch->getId());

        $mapper = $this->mappers->driver($subject['mapper']);
        $targetItemList = $this->mappers->createTargetItemList($batch, $mapper);
        $item = new Item($subject['item']);
        $targetItem = $targetItemList->getMatchedTargetItem($item);
        if (is_object($targetItem)) {
            $batchTargetItem = $this->mappers->createBatchTargetItem();
            $batchTargetItem->setBatch($batch);
            $batchTargetItem->setTargetItem($targetItem);
            $em->persist($batchTargetItem);
            $batch->target_items->add($batchTargetItem);
            $em->persist($batch);
            $em->flush();
        }
    }

    public function finish(ActionInterface $action)
    {
        return;
    }
}
