<?php

namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Attribute;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\AttributeValue;

defined('C5_EXECUTE') or die('Access Denied.');

class StandardPublisher implements PublisherInterface
{
    public function publish($attributeKey, $subject, AttributeValue $value)
    {
        $inspector = \Core::make('import/value_inspector');
        $result = $inspector->inspect($value->getValue());
        $content = $result->getReplacedContent();
        $subject->setAttribute($attributeKey->getAttributeKeyHandle(), $content);
    }
}
