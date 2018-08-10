<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Command;

use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\PresetManager;

class MapContentTypesCommandHandler
{

    public function handle(MapContentTypesCommand $command)
    {
        // Since batch is serialized we do this:
        $em = \Database::connection()->getEntityManager();
        $batch = $em->getRepository('PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch')->findOneById($command->getBatchId());

        $mappers = \Core::make('migration/manager/mapping');
        $mapper = $mappers->driver($command->getMapper());
        $targetItemList = $mappers->createTargetItemList($batch, $mapper);
        $item = new Item($command->getItem());
        $selectedTargetItem = $targetItemList->getSelectedTargetItem($item, false);
        if (!is_object($selectedTargetItem)) {
            // We're dealing with a new one that we haven't seen, so we try and assign it.
            $presetManager = new PresetManager($em);
            $targetItem = $presetManager->getMatchedTargetItem($mapper, $batch, $item);
            if (!is_object($targetItem)) {
                $targetItem = $targetItemList->getMatchedTargetItem($item);
            }
            if (is_object($targetItem)) {
                $batchTargetItem = $mappers->createBatchTargetItem();
                $batchTargetItem->setBatch($batch);
                $batchTargetItem->setTargetItem($targetItem);
                $em->persist($batchTargetItem);
                $batch->target_items->add($batchTargetItem);
                $em->persist($batch);
                $em->flush();
            }
        }
    }


}