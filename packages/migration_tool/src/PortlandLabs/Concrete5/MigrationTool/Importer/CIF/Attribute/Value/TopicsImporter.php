<?php

namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Attribute\Value;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\AttributeValue;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\ImageFileAttributeValue;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\SelectAttributeValue;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\StandardAttributeValue;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\TopicsAttributeValue;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\ImporterInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class TopicsImporter implements ImporterInterface
{
    public function parse(\SimpleXMLElement $node)
    {
        $value = new TopicsAttributeValue();
        $topics = array();
        if ($node->topics->topic) {
            foreach($node->topics->topic as $topic) {
                $topics[] = (string) $topic;
            }
        }
        $value->setValue($topics);
        return $value;
    }

}
