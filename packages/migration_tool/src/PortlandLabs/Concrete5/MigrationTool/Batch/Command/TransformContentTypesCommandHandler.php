<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Command;

use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\IgnoredTargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\UnmappedTargetItem;

class TransformContentTypesCommandHandler
{

    public function handle(TransformContentTypesCommand $command)
    {
        $em = \Database::connection()->getEntityManager();
        $batch = $em->getRepository('PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch')->findOneById($command->getBatchId());

        $transformers = \Core::make('migration/manager/transforms');
        $mappers = \Core::make('migration/manager/mapping');
        $transformer = $transformers->driver($command->getTransformer());
        $entity = $transformer->getUntransformedEntityByID($command->getEntity());
        if (is_object($entity)) {
            $item = $transformer->getItem($entity);

            // Since batch is serialized we do this:
            $batch = $em->getRepository('PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch')->findOneById($batch->getId());
            $mapper = $mappers->driver($command->getMapper());

            if (is_object($item)) {
                $targetItemList = $mappers->createTargetItemList($batch, $mapper);
                $targetItem = $targetItemList->getSelectedTargetItem($item);
                if (is_object($targetItem)) {
                    if ($targetItem instanceof IgnoredTargetItem || $targetItem instanceof UnmappedTargetItem) {
                        return;
                    }

                    $transformer->transform($entity, $mapper, $item, $targetItem, $batch);
                    $em->flush();
                }
            }
        }
    }


}