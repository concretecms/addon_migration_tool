<?php

namespace PortlandLabs\Concrete5\MigrationTool\Importer\Block;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\StandardBlockValue;
use PortlandLabs\Concrete5\MigrationTool\Importer\ImporterInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class StandardImporter implements ImporterInterface
{
    public function parse(\SimpleXMLElement $node)
    {
        $value = new StandardBlockValue();
        $data = array();
        foreach ($node->record->children() as $field) {
            $data[$field->getName()] = (string) $field;
        }
        $value->setData($data);
        return $value;
    }

}
