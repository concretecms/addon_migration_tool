<?php

namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\Attribute\StandardFormatter;

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
