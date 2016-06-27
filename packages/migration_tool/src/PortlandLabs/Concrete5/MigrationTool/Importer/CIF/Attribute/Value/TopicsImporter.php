<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Attribute\Value;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\TopicsAttributeValue;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\ImporterInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class TopicsImporter extends AbstractImporter
{
    public function parse(\SimpleXMLElement $node)
    {
        $value = new TopicsAttributeValue();
        $topics = array();
        if ($node->topics->topic) {
            foreach ($node->topics->topic as $topic) {
                $topics[] = (string) $topic;
            }
        }
        $value->setValue($topics);

        return $value;
    }
}
