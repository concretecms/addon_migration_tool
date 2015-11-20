<?php

namespace PortlandLabs\Concrete5\MigrationTool\Importer\Parser\CIF\Attribute\Key;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\BooleanAttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\RatingAttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\SocialLinksAttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\TextAttributeKey;

defined('C5_EXECUTE') or die("Access Denied.");

class SocialLinksImporter implements ImporterInterface
{

    public function getEntity()
    {
        return new SocialLinksAttributeKey();
    }

    public function loadFromXml(AttributeKey $key, \SimpleXMLElement $element)
    {
        return false;
    }

}
