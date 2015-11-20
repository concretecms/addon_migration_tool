<?php

namespace PortlandLabs\Concrete5\MigrationTool\Importer\Parser\CIF\Permission\AccessEntity;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\UnknownAttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Permission\AccessEntity;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Permission\GroupAccessEntity;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Permission\UserAccessEntity;

defined('C5_EXECUTE') or die("Access Denied.");

class UserImporter implements ImporterInterface
{

    public function getEntity()
    {
        return new UserAccessEntity();
    }

    public function loadFromXml(AccessEntity $entity, \SimpleXMLElement $element)
    {
        $entity->setUserName((string) $element['name']);
    }

}
