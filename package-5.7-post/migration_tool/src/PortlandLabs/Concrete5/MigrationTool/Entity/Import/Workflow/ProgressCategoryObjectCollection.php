<?php

namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\Workflow;

use Doctrine\Common\Collections\ArrayCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\ObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Formatter\BlockTypeFormatter;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Formatter\ConversationFlagTypeFormatter;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Formatter\PageTemplateFormatter;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Formatter\WorkflowProgressCategoryFormatter;

/**
 * @Entity
 */
class ProgressCategoryObjectCollection extends ObjectCollection
{

    /**
     * @OneToMany(targetEntity="ProgressCategory", mappedBy="collection", cascade={"persist", "remove"})
     **/
    public $categories;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getCategories()
    {
        return $this->categories;
    }

    public function getFormatter()
    {
        return new WorkflowProgressCategoryFormatter($this);
    }

    public function getType()
    {
        return 'workflow_progress_category';
    }

    public function hasRecords()
    {
        return count($this->getCategories());
    }

    public function getRecords()
    {
        return $this->getCategories();
    }

    public function getTreeFormatter()
    {
        return false;
    }

    public function getRecordValidator()
    {
        return false;
    }





}
