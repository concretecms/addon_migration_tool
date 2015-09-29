<?php

namespace PortlandLabs\Concrete5\MigrationTool\Importer\Attribute\Value;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\ImportedAttributeValue;
use PortlandLabs\Concrete5\MigrationTool\Importer\ImporterInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class Importer implements ImporterInterface
{
    public function parse(\SimpleXMLElement $node)
    {
        $value = new ImportedAttributeValue();
        $value->setValue((string) $node->asXML());
        return $value;
    }

}
