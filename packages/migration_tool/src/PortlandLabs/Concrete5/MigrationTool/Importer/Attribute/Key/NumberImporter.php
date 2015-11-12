<?php

namespace PortlandLabs\Concrete5\MigrationTool\Importer\Attribute\Key;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\BooleanAttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\NumberAttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\RatingAttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\TextAttributeKey;

defined('C5_EXECUTE') or die("Access Denied.");

class NumberImporter implements ImporterInterface
{

    public function getEntity()
    {
        return new NumberAttributeKey();
    }

    public function loadFromXml(AttributeKey $key, \SimpleXMLElement $element)
    {
        return false;
    }

}
