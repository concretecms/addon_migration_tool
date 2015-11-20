<?php

namespace PortlandLabs\Concrete5\MigrationTool\Importer\Parser\CIF\Attribute\Key;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\BooleanAttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\TextAreaAttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\TextAttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\TopicsAttributeKey;

defined('C5_EXECUTE') or die("Access Denied.");

class TopicsImporter implements ImporterInterface
{

    public function getEntity()
    {
        return new TopicsAttributeKey();
    }

    /**
     * @param TopicsAttributeKey $key
     * @param \SimpleXMLElement $element
     * @return bool
     */
    public function loadFromXml(AttributeKey $key, \SimpleXMLElement $element)
    {
        $name = (string) $element->tree['name'];
        $path = (string) $element->tree['path'];
        $key->setTreeName($name);
        $key->setNodePath($path);
    }

}
