<?php

namespace PortlandLabs\Concrete5\MigrationTool\Importer\Parser\CIF\Attribute\Value;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\AddressAttributeValue;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\AttributeValue;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\ImageFileAttributeValue;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\SelectAttributeValue;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\StandardAttributeValue;
use PortlandLabs\Concrete5\MigrationTool\Importer\Parser\CIF\ImporterInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class AddressImporter implements ImporterInterface
{
    public function parse(\SimpleXMLElement $node)
    {
        $value = new AddressAttributeValue();
        $value->setAddress1((string) $node->value['address1']);
        $value->setAddress2((string) $node->value['address2']);
        $value->setAddress3((string) $node->value['address3']);
        $value->setCity((string) $node->value['city']);
        $value->setStateProvince((string) $node->value['state-province']);
        $value->setPostalCode((string) $node->value['postal-code']);
        $value->setCountry((string) $node->value['country']);
        return $value;
    }

}
