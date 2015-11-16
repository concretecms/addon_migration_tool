<?php

namespace PortlandLabs\Concrete5\MigrationTool\Importer\Block;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue\ImportedBlockValue;
use PortlandLabs\Concrete5\MigrationTool\Importer\ImporterInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class Importer implements ImporterInterface
{
    public function parse(\SimpleXMLElement $node)
    {
        $value = new ImportedBlockValue();
        $value->setValue((string) $node->asXML());
        return $value;
    }

}
