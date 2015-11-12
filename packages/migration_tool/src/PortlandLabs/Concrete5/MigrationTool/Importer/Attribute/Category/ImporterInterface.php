<?php

namespace PortlandLabs\Concrete5\MigrationTool\Importer\Attribute\Category;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKeyCategoryInstance;

defined('C5_EXECUTE') or die("Access Denied.");

interface ImporterInterface
{
    public function getEntity();
    public function loadFromXml(AttributeKeyCategoryInstance $key, \SimpleXMLElement $element);

}
