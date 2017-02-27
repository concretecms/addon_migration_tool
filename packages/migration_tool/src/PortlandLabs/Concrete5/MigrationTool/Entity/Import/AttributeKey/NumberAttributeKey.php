<?php

namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\AttributeKey\BlankFormatter;

/**
 * @Entity
 * @Table(name="MigrationImportNumberAttributeKeys")
 */
class NumberAttributeKey extends AttributeKey
{
    public function getType()
    {
        return 'number';
    }

    public function getFormatter()
    {
        return new BlankFormatter($this);
    }
}
