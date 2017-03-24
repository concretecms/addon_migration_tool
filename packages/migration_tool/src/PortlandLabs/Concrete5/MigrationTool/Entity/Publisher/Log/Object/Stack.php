<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Object;

use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Object\LoggableObject;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\Formatter\Object\AttributeKeyCategoryFormatter;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\Formatter\Object\AttributeSetFormatter;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\Formatter\Object\GroupFormatter;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\Formatter\Object\PageFormatter;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\Formatter\Object\StackFormatter;
use PortlandLabs\Concrete5\MigrationTool\Publisher\PublishableInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Validator\AttributeKeyCategoryValidator;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Stack extends AbstractStack
{

    public function getLogFormatter()
    {
        return new StackFormatter();
    }


}
