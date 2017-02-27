<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Attribute;

use Concrete\Core\Attribute\Key\CollectionKey;
use Concrete\Core\Attribute\ObjectTrait;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\AttributeValue;
use Concrete\Core\Page\Page;

defined('C5_EXECUTE') or die("Access Denied.");

class SocialLinksPublisher implements PublisherInterface
{
    public function publish($ak, $subject, AttributeValue $value)
    {
        $links = $value->getValue();
        $r = array();
        foreach ($links as $link) {
            $r[$link['service']] = $link['detail'];
        }
        $subject->setAttribute($ak->getAttributeKeyHandle(), $r);
    }
}
