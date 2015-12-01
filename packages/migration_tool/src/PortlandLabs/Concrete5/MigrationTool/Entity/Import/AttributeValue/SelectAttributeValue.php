<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\Attribute\SelectFormatter;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Attribute\StandardPublisher;

/**
 * @Entity
 * @Table(name="MigrationImportAttributeSelectValues")
 */
class SelectAttributeValue extends AttributeValue
{
    /**
     * @Column(type="json_array")
     */
    protected $value;

    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    public function getFormatter()
    {
        return new SelectFormatter($this);
    }

    public function getPublisher()
    {
        return new StandardPublisher();
    }
}
