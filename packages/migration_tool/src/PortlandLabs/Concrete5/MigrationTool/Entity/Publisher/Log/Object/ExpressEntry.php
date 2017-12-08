<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Object;

use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Object\LoggableObject;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\Formatter\Object\AttributeKeyCategoryFormatter;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\Formatter\Object\AttributeSetFormatter;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\Formatter\Object\ExpressEntityFormatter;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\Formatter\Object\GroupFormatter;
use PortlandLabs\Concrete5\MigrationTool\Publisher\PublishableInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Validator\AttributeKeyCategoryValidator;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="MigrationPublisherLogExpressEntries")
 */
class ExpressEntry extends LoggableObject
{

    /**
     * @ORM\Column(type="string")
     */
    protected $computedName;

    /**
     * @ORM\ManyToOne(targetEntity="\Concrete\Core\Entity\Express\Entry")
     * @ORM\JoinColumn(name="exEntryID", referencedColumnName="exEntryID"),
     */
    protected $publishedEntry;


    /**
     * @return mixed
     */
    public function getComputedName()
    {
        return $this->computedName;
    }

    /**
     * @param mixed $name
     */
    public function setComputedName($computedName)
    {
        $this->computedName = $computedName;
    }

    /**
     * @return mixed
     */
    public function getPublishedEntry()
    {
        return $this->publishedEntry;
    }

    /**
     * @param mixed $publishedEntry
     */
    public function setPublishedEntry($publishedEntry)
    {
        $this->publishedEntry = $publishedEntry;
    }


    public function getLogFormatter()
    {
        return new ExpressEntityFormatter();
    }
}
