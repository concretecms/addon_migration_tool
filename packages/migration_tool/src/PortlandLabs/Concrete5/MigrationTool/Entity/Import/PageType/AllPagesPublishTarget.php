<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageType;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\PageType\AllPagesPublishTargetFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\PageType\AllPagesPublishTargetValidator;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorInterface;

/**
 * @Entity
 */
class AllPagesPublishTarget extends PublishTarget
{
    /**
     * @Column(type="string")
     */
    protected $form_factor;

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
        return new AllPagesPublishTargetFormatter($this);
    }

    public function getRecordValidator(ValidatorInterface $batch)
    {
        return new AllPagesPublishTargetValidator($batch);
    }
}
