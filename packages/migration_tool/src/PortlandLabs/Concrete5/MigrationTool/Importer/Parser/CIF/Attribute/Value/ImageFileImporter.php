<?php

namespace PortlandLabs\Concrete5\MigrationTool\Importer\Parser\CIF\Attribute\Value;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\AttributeValue;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\ImageFileAttributeValue;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\SelectAttributeValue;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\StandardAttributeValue;
use PortlandLabs\Concrete5\MigrationTool\Importer\Parser\CIF\ImporterInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class ImageFileImporter implements ImporterInterface
{
    public function parse(\SimpleXMLElement $node)
    {
        $value = new ImageFileAttributeValue();
        $value->setValue((string) $node->value->fID);
        return $value;
    }

}
