<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\Wordpress\Block;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue\StandardBlockDataRecord;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue\StandardBlockValue;
use PortlandLabs\Concrete5\MigrationTool\Importer\Wordpress\ImporterInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class StandardImporter implements ImporterInterface
{
    public function createBlockValueObject()
    {
        return new StandardBlockValue();
    }

    public function parse(\SimpleXMLElement $node)
    {
        // TODO finish this bad boy...
        $content = $node->children( 'http://purl.org/rss/1.0/modules/content/' );
        $value = $this->createBlockValueObject();
        $position = 0;
        foreach ($node->data as $data) {
            foreach ($data->record as $record) {
                $r = new StandardBlockDataRecord();
                $r->setTable((string) $data['table']);
                $recordData = array();
                foreach ($record->children() as $field) {
                    $recordData[$field->getName()] = (string) $field;
                }
                $r->setData($recordData);
                $r->setValue($value);
                $r->setPosition($position);
                $value->getRecords()->add($r);
                ++$position;
            }
        }

        return $value;
    }
}
