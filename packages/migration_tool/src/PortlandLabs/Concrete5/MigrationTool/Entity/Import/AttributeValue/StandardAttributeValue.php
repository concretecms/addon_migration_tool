<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\Attribute\StandardFormatter;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Attribute\StandardPublisher;

/**
 * @Entity
 * @Table(name="MigrationImportAttributeStandardValues")
 */
class StandardAttributeValue extends AttributeValue
{
    /**
     * @Column(type="text")
     */
    protected $standard_value;

    public function getValue()
    {
        return $this->standard_value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($standard_value)
    {
        $this->standard_value = $standard_value;
    }

    public function getFormatter()
    {
        return new StandardFormatter($this);
    }

    public function getPublisher()
    {
        return new StandardPublisher();
    }
}
