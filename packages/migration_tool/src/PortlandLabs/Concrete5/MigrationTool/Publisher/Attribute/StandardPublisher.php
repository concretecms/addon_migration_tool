<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Attribute;

use Concrete\Core\Attribute\Key\CollectionKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\AttributeValue;
use Concrete\Core\Page\Page;

defined('C5_EXECUTE') or die("Access Denied.");

class StandardPublisher implements PublisherInterface
{
    public function publish(CollectionKey $ak, Page $page, AttributeValue $value)
    {
        $inspector = \Core::make('import/value_inspector');
        $result = $inspector->inspect($value->getValue());
        $content = $result->getReplacedContent();
        $page->setAttribute($ak->getAttributeKeyHandle(), $content);
    }
}
