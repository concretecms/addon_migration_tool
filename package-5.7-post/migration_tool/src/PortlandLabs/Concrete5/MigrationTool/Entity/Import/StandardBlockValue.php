<?php

namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;

use Doctrine\Common\Collections\ArrayCollection;
use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\Block\StandardFormatter;
use PortlandLabs\Concrete5\MigrationTool\Inspector\Block\StandardInspector;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Block\Manager;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Block\StandardPublisher;

/**
 * @Entity
 */
class StandardBlockValue extends BlockValue
{

    /**
     * @OneToMany(targetEntity="\PortlandLabs\Concrete5\MigrationTool\Entity\Import\StandardBlockDataRecord", mappedBy="value", cascade={"persist", "remove"})
     * @OrderBy({"position" = "ASC"})
     **/
    public $records;

    public function getFormatter()
    {
        return new StandardFormatter($this);
    }

    public function getPublisher()
    {
        $manager = \Core::make('migration/manager/publisher/block');
        $type = $this->getBlock()->getType();
        return $manager->driver($type);
    }

    /**
     * @return mixed
     */
    public function getRecords()
    {
        return $this->records;
    }

    /**
     * @param mixed $records
     */
    public function setRecords($records)
    {
        $this->records = $records;
    }

    public function getInspector()
    {
        return new StandardInspector($this);
    }

    public function __construct()
    {
        $this->records = new ArrayCollection();
    }

}
