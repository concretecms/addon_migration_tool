<?php

namespace PortlandLabs\Concrete5\MigrationTool\Importer\Parser\CIF\Attribute\Key;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\BooleanAttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\TextAreaAttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\TextAttributeKey;

defined('C5_EXECUTE') or die("Access Denied.");

class TextAreaImporter implements ImporterInterface
{

    public function getEntity()
    {
        return new TextAreaAttributeKey();
    }

    /**
     * @param TextAreaAttributeKey $key
     * @param \SimpleXMLElement $element
     * @return bool
     */
    public function loadFromXml(AttributeKey $key, \SimpleXMLElement $element)
    {
        $mode = (string) $element->type['mode'];
        $key->setMode($mode);
    }

}
