<?php

namespace PortlandLabs\Concrete5\MigrationTool\Importer\Attribute\Type;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\ImportedAttributeValue;

defined('C5_EXECUTE') or die("Access Denied.");

class Importer implements ImporterInterface
{
    public function parse(\SimpleXMLElement $node)
    {
        $value = new ImportedAttributeValue();
        $value->setValue((string) $node->value->asXML());
        return $value;
    }

}
