<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\AttributeKey;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKey;
use Concrete\Core\Attribute\Key\Key as CoreAttributeKey;

defined('C5_EXECUTE') or die("Access Denied.");

interface PublisherInterface
{
    /**
     * Note: the destination should be an attribute key but we can't type hint against it because in
     * 5.7 it doesn't have an interface and in version 8 it does.
     * @param AttributeKey $source
     * @param $destination
     *
     * @return mixed
     */
    public function publish(AttributeKey $source, $destination);
}
