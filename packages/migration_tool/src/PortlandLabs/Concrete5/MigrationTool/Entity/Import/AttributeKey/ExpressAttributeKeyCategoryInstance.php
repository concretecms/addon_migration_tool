<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey;

use PortlandLabs\Concrete5\MigrationTool\Publisher\AttributeKeyCategory\ExpressPublisher;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class ExpressAttributeKeyCategoryInstance extends AttributeKeyCategoryInstance
{
    public function getHandle()
    {
        return 'express';
    }

    public function getFormatter()
    {
        return false;
    }

    public function getPublisher()
    {
        return new ExpressPublisher();
    }
}
