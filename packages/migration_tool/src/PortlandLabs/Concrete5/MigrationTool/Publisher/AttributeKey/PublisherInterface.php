<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\AttributeKey;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKey;
use Concrete\Core\Attribute\Key\Key as CoreAttributeKey;

defined('C5_EXECUTE') or die("Access Denied.");

interface PublisherInterface
{
    /**
     * @param AttributeKey $source
     * @param CoreAttributeKey $destination
     *
     * @return mixed
     */
    public function publish(AttributeKey $source, CoreAttributeKey $destination);
}
