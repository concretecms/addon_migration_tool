<?php

namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageType;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\PageType\PageTypePublishTargetFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\PermissionKey\GroupAccessEntityFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\PageType\PageTypePublishTargetValidator;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\PermissionKey\GroupAccessEntityValidator;
use PortlandLabs\Concrete5\MigrationTool\Publisher\PublishableInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Validator\PermissionAccessEntityTypeValidator;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

/**
 * @Entity
 */
class PageTypePublishTarget extends PublishTarget
{

    /**
     * @Column(type="string")
     */
    protected $page_type;

    /**
     * @Column(type="string")
     */
    protected $form_factor;

    /**
     * @return mixed
     */
    public function getPageType()
    {
        return $this->page_type;
    }

    /**
     * @param mixed $page_type
     */
    public function setPageType($page_type)
    {
        $this->page_type = $page_type;
    }

    /**
     * @return mixed
     */
    public function getFormFactor()
    {
        return $this->form_factor;
    }

    /**
     * @param mixed $form_factor
     */
    public function setFormFactor($form_factor)
    {
        $this->form_factor = $form_factor;
    }

    public function getFormatter()
    {
        return new PageTypePublishTargetFormatter($this);
    }

    public function getRecordValidator(Batch $batch)
    {
        return new PageTypePublishTargetValidator($batch);
    }



}
