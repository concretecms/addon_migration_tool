<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Block;

defined('C5_EXECUTE') or die("Access Denied.");

class PageListImporter extends StandardImporter
{
    public function parse(\SimpleXMLElement $node)
    {
        $value = parent::parse($node);

        foreach ($value->getRecords() as $record) {
            $data = $record->getData();
            if (!isset($data['includeDescription'])) {
                $data['includeDescription'] = true;
            }
            if (!isset($data['includeName'])) {
                $data['includeName'] = true;
            }
            $record->setData($data);
        }

        return $value;
    }
}
