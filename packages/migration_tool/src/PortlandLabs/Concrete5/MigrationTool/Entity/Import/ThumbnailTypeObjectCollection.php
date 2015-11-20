<?php

namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;

use Doctrine\Common\Collections\ArrayCollection;
use PortlandLabs\Concrete5\MigrationTool\Importer\Formatter\ThumbnailTypeFormatter;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

/**
 * @Entity
 */
class ThumbnailTypeObjectCollection extends ObjectCollection
{

    /**
     * @OneToMany(targetEntity="\PortlandLabs\Concrete5\MigrationTool\Entity\Import\ThumbnailType", mappedBy="collection", cascade={"persist", "remove"})
     **/
    public $types;

    public function __construct()
    {
        $this->types = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getTypes()
    {
        return $this->types;
    }

    public function getFormatter()
    {
        return new ThumbnailTypeFormatter($this);
    }

    public function getType()
    {
        return 'thumbnail_type';
    }

    public function hasRecords()
    {
        return count($this->getTypes());
    }

    public function getRecords()
    {
        return $this->getTypes();
    }

    public function getTreeFormatter()
    {
        return false;
    }

    public function getRecordValidator(Batch $batch)
    {
        return false;
    }





}
