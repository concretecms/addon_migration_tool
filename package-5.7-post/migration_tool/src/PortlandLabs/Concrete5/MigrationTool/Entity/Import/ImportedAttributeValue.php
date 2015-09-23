<?php

namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;

use PortlandLabs\Concrete5\MigrationTool\Importer\Attribute\Type\ImportedFormatter;
use PortlandLabs\Concrete5\MigrationTool\Importer\Attribute\Type\StandardFormatter;

/**
 * @Entity
 */
class ImportedAttributeValue extends AttributeValue
{

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



}
