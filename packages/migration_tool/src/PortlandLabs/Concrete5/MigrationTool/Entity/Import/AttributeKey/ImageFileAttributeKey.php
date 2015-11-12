<?php

namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\AttributeKey\BlankFormatter;


/**
 * @Entity
 * @Table(name="MigrationImportImageFileAttributeKeys")
 */
class ImageFileAttributeKey extends AttributeKey
{

    public function getType()
    {
        return 'image_file';
    }

    public function getFormatter()
    {
        return new BlankFormatter($this);
    }

}
