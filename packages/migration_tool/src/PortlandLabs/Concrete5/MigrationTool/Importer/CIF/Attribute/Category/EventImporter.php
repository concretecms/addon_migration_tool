<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Attribute\Category;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKeyCategoryInstance;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\EventAttributeKeyCategoryInstance;

defined('C5_EXECUTE') or die("Access Denied.");

class EventImporter implements ImporterInterface
{
    public function getEntity()
    {
        return new EventAttributeKeyCategoryInstance();
    }

    public function loadFromXml(AttributeKeyCategoryInstance $category, \SimpleXMLElement $element)
    {
        return false;
    }
}
