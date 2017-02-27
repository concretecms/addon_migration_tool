<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Attribute;

use Concrete\Core\Attribute\Key\CollectionKey;
use Concrete\Core\Attribute\ObjectTrait;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\AttributeValue;
use Concrete\Core\Page\Page;

defined('C5_EXECUTE') or die("Access Denied.");

interface PublisherInterface
{
    public function publish($attributeKey, $subject, AttributeValue $value);
}
