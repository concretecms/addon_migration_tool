<?php

namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Attribute;


use Concrete\Core\Attribute\Key\CollectionKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue;
use Concrete\Core\Page\Page;

defined('C5_EXECUTE') or die("Access Denied.");

class CIFPublisher implements PublisherInterface
{

    public function publish(CollectionKey $ak, Page $page, AttributeValue $value)
    {
        $node = simplexml_load_string($value->getValueXml());
        $page->setAttribute($value->getAttribute()->getHandle(), $ak->getController()->importValue($node));
    }

}
