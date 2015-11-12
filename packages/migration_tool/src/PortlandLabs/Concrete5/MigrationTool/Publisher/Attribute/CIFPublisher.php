<?php

namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Attribute;


use Concrete\Core\Attribute\Key\CollectionKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\AttributeValue;
use Concrete\Core\Page\Page;

defined('C5_EXECUTE') or die("Access Denied.");

class CIFPublisher implements PublisherInterface
{

    public function publish(CollectionKey $ak, Page $page, AttributeValue $value)
    {
        $node = simplexml_load_string($value->getValue());
        $page->setAttribute($ak->getAttributeKeyHandle(), $ak->getController()->importValue($node));
    }

}
