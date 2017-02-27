<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\AttributeKey\BlankFormatter;

/**
 * @Entity
 * @Table(name="MigrationImportSocialLinksAttributeKeys")
 */
class SocialLinksAttributeKey extends AttributeKey
{
    public function getType()
    {
        return 'social_links';
    }

    public function getFormatter()
    {
        return new BlankFormatter($this);
    }
}
