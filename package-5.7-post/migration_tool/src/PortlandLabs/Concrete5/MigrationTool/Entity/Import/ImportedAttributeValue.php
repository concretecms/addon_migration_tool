<?php

namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\Attribute\ImportedFormatter;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Attribute\CIFPublisher;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Attribute\StandardPublisher;

/**
 * @Entity
 * @Table(name="MigrationImportAttributeStandardValues")
 */
class ImportedAttributeValue extends AttributeValue
{

    /**
     * @Column(type="text")
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
        return new ImportedFormatter($this);
    }

    public function getPublisher()
    {
        return new CIFPublisher();
    }


}
