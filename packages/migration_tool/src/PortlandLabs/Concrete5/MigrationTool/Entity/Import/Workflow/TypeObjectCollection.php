<?php

namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\Workflow;

use Doctrine\Common\Collections\ArrayCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\ObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Importer\Formatter\BlockTypeFormatter;
use PortlandLabs\Concrete5\MigrationTool\Importer\Formatter\ConversationRatingTypeFormatter;
use PortlandLabs\Concrete5\MigrationTool\Importer\Formatter\PageTemplateFormatter;
use PortlandLabs\Concrete5\MigrationTool\Importer\Formatter\WorkflowTypeFormatter;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

/**
 * @Entity
 */
class TypeObjectCollection extends ObjectCollection
{

    /**
     * @OneToMany(targetEntity="Type", mappedBy="collection", cascade={"persist", "remove"})
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
        return new WorkflowTypeFormatter($this);
    }

    public function getType()
    {
        return 'workflow_type';
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
