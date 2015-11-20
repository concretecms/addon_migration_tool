<?php

namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;

use Doctrine\Common\Collections\ArrayCollection;
use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\Stack\TreeJsonFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Stack\Validator;
use PortlandLabs\Concrete5\MigrationTool\Importer\Formatter\StackFormatter;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

/**
 * @Entity
 */
class StackObjectCollection extends ObjectCollection
{

    /**
     * @OneToMany(targetEntity="\PortlandLabs\Concrete5\MigrationTool\Entity\Import\Stack", mappedBy="collection", cascade={"persist", "remove"})
     **/
    public $stacks;

    public function __construct()
    {
        $this->stacks = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getStacks()
    {
        return $this->stacks;
    }

    public function getFormatter()
    {
        return new StackFormatter($this);
    }

    public function getType()
    {
        return 'stack';
    }

    public function hasRecords()
    {
        return count($this->getStacks());
    }

    public function getRecords()
    {
        return $this->getStacks();
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
