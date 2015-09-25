<?php

namespace PortlandLabs\Concrete5\MigrationTool\Importer\Block;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\StandardBlockDataRecord;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\StandardBlockValue;
use PortlandLabs\Concrete5\MigrationTool\Importer\ImporterInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class StandardImporter implements ImporterInterface
{
    public function parse(\SimpleXMLElement $node)
    {
        $value = new StandardBlockValue();
        $position = 0;
        foreach ($node->data as $data) {
            foreach($data->record as $record) {
                $r = new StandardBlockDataRecord();
                $r->setTable((string) $data['table']);
                $recordData = array();
                foreach($record->children() as $field) {
                    $recordData[$field->getName()] = (string) $field;
                }
                $r->setData($recordData);
                $r->setValue($value);
                $r->setPosition($position);
                $value->getRecords()->add($r);
                $position++;
            }
        }
        return $value;
    }

}
