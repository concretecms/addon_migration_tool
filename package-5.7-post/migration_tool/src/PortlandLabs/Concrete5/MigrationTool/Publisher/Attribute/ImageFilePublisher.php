<?php

namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Attribute;


use Concrete\Core\Attribute\Key\CollectionKey;
use Concrete\Core\Backup\ContentImporter\ValueInspector\Item\FileItem;
use Concrete\Core\Backup\ContentImporter\ValueInspector\ValueInspector;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\AttributeValue;
use Concrete\Core\Page\Page;

defined('C5_EXECUTE') or die("Access Denied.");

class ImageFilePublisher implements PublisherInterface
{

    public function publish(CollectionKey $ak, Page $page, AttributeValue $value)
    {
        $inspector = new ValueInspector($value->getValue());
        $content = $inspector->getMatchedItem(); // file object
        if (is_object($content) && $content instanceof FileItem) {
            $file = $content->getContentObject();
            $page->setAttribute($ak->getAttributeKeyHandle(), $file);
        }
    }

}
