<?php

namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Attribute;


use Concrete\Core\Attribute\Key\CollectionKey;
use Concrete\Core\Backup\ContentImporter\ValueInspector\ValueInspector;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\AttributeValue;
use Concrete\Core\Page\Page;

defined('C5_EXECUTE') or die("Access Denied.");

class StandardPublisher implements PublisherInterface
{

    public function publish(CollectionKey $ak, Page $page, AttributeValue $value)
    {
        $inspector = new ValueInspector($value->getValue());
        $content = $inspector->getReplacedContent();
        $page->setAttribute($value->getAttribute()->getHandle(), $content);
    }

}
