<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Attribute;

use Concrete\Core\Attribute\Key\CollectionKey;
use Concrete\Core\Attribute\ObjectTrait;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\AttributeValue;
use Concrete\Core\Page\Page;

defined('C5_EXECUTE') or die("Access Denied.");

class CIFPublisher implements PublisherInterface
{
    public function publish($ak, $subject, AttributeValue $value)
    {
        $node = simplexml_load_string($value->getValue());
        $subject->setAttribute($ak->getAttributeKeyHandle(), $ak->getController()->importValue($node));
    }
}
