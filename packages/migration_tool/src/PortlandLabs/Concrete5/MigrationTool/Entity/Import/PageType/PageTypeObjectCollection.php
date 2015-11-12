<?php

namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageType;

use Doctrine\Common\Collections\ArrayCollection;
use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\PageType\TreeJsonFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\PageType\Validator;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\ObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Formatter\PageTypeFormatter;

/**
 * @Entity
 */
class PageTypeObjectCollection extends ObjectCollection
{

    /**
     * @OneToMany(targetEntity="PageType", mappedBy="collection", cascade={"persist", "remove"})
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
        return new PageTypeFormatter($this);
    }

    public function getType()
    {
        return 'page_type';
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
        return new TreeJsonFormatter($this);
    }

    public function getRecordValidator(Batch $batch)
    {
        return new Validator($batch);
    }



}
