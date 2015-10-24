<?php

namespace PortlandLabs\Concrete5\MigrationTool\Publisher\AttributeKey;


use Concrete\Core\Attribute\Key\CollectionKey;
use Concrete\Core\Attribute\Key\Key as CoreAttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\DateTimeAttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue;
use Concrete\Core\Page\Page;

defined('C5_EXECUTE') or die("Access Denied.");

class DateTimePublisher implements PublisherInterface
{

    /**
     * @param DateTimeAttributeKey $source
     * @param CoreAttributeKey $destination
     */
    public function publish(AttributeKey $source, CoreAttributeKey $destination)
    {
        $controller = $destination->getController();
        $data = array();
        $data['akDateDisplayMode'] = $source->getMode();
        $controller->saveKey($data);
    }
}