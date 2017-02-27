<?php

namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use Concrete\Core\Block\BlockType\BlockType;
use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;

defined('C5_EXECUTE') or die('Access Denied.');

class CreateBlockTypesRoutine extends AbstractRoutine
{
    public function execute(BatchInterface $batch)
    {
        $types = $batch->getObjectCollection('block_type');

        if (!$types) {
            return;
        }

        foreach ($types->getTypes() as $type) {
            if (!$type->getPublisherValidator()->skipItem()) {
                $pkg = null;
                if ($type->getPackage()) {
                    $pkg = \Package::getByHandle($type->getPackage());
                }
                if (is_object($pkg)) {
                    BlockType::installBlockTypeFromPackage($type->getHandle(), $pkg);
                } else {
                    BlockType::installBlockType($type->getHandle());
                }
            }
        }
    }
}
