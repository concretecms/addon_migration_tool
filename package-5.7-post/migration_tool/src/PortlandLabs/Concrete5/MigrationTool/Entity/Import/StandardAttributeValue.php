<?php

namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;

use PortlandLabs\Concrete5\MigrationTool\Importer\Attribute\Type\StandardFormatter;

/**
 * @Entity
 */
class StandardAttributeValue extends ImportedAttributeValue
{

    public function getFormatter()
    {
        return new StandardFormatter($this);
    }

}
