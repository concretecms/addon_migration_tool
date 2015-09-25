<?php

namespace PortlandLabs\Concrete5\MigrationTool\Importer\Attribute;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\StandardAttributeValue;
use PortlandLabs\Concrete5\MigrationTool\Importer\ImporterInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class StandardImporter implements ImporterInterface
{
    public function parse(\SimpleXMLElement $node)
    {
        $value = new StandardAttributeValue();
        $value->setValue((string) $node->value);
        return $value;
    }

}
