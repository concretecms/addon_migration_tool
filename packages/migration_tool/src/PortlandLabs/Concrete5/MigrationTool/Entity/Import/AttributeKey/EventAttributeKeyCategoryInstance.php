<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey;

use PortlandLabs\Concrete5\MigrationTool\Publisher\AttributeKeyCategory\EventPublisher;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class EventAttributeKeyCategoryInstance extends AttributeKeyCategoryInstance
{
    public function getHandle()
    {
        return 'event';
    }

    public function getFormatter()
    {
        return false;
    }

    public function getPublisher()
    {
        return new EventPublisher();
    }
}
