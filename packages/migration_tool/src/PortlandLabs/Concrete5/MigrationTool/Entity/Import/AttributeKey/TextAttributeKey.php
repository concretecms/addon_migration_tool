<?php

namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\AttributeKey\BlankFormatter;


/**
 * @Entity
 * @Table(name="MigrationImportTextAttributeKeys")
 */
class TextAttributeKey extends AttributeKey
{

    public function getType()
    {
        return 'text';
    }

    public function getFormatter()
    {
        return new BlankFormatter($this);
    }

}
