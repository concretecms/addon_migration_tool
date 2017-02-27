<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Attribute;

use Concrete\Core\Attribute\Key\CollectionKey;
use Concrete\Core\Attribute\ObjectTrait;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\AttributeValue;
use Concrete\Core\Page\Page;

defined('C5_EXECUTE') or die("Access Denied.");

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
