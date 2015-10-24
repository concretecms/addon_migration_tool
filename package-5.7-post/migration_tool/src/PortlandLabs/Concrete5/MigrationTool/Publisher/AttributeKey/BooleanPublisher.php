<?php

namespace PortlandLabs\Concrete5\MigrationTool\Publisher\AttributeKey;


use Concrete\Core\Attribute\Key\CollectionKey;
use Concrete\Core\Attribute\Key\Key as CoreAttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\BooleanAttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue;
use Concrete\Core\Page\Page;

defined('C5_EXECUTE') or die("Access Denied.");

class BooleanPublisher implements PublisherInterface
{

    /**
     * @param BooleanAttributeKey $source
     * @param CoreAttributeKey $destination
     */
    public function publish(AttributeKey $source, CoreAttributeKey $destination)
    {
        $controller = $destination->getController();
        $data = array();
        $data['akCheckedByDefault'] = $source->getIsChecked();
        $controller->saveKey($data);
    }
}