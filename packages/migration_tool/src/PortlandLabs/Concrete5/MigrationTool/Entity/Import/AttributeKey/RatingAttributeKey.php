<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\AttributeKey\BlankFormatter;

/**
 * @Entity
 * @Table(name="MigrationImportRatingAttributeKeys")
 */
class RatingAttributeKey extends AttributeKey
{
    public function getType()
    {
        return 'rating';
    }

    public function getFormatter()
    {
        return new BlankFormatter($this);
    }
}
