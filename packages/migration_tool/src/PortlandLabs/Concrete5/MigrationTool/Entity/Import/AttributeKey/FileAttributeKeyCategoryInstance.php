<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey;

use PortlandLabs\Concrete5\MigrationTool\Publisher\AttributeKeyCategory\FilePublisher;

/**
 * @Entity
 */
class FileAttributeKeyCategoryInstance extends AttributeKeyCategoryInstance
{
    public function getHandle()
    {
        return 'file';
    }

    public function getFormatter()
    {
        return false;
    }

    public function getPublisher()
    {
        return new FilePublisher();
    }
}
