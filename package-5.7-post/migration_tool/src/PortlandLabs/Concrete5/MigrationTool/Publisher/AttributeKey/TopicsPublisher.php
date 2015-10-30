<?php

namespace PortlandLabs\Concrete5\MigrationTool\Publisher\AttributeKey;


use Concrete\Core\Attribute\Key\CollectionKey;
use Concrete\Core\Attribute\Key\Key as CoreAttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\TopicsAttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\AttributeValue;
use Concrete\Core\Page\Page;

defined('C5_EXECUTE') or die("Access Denied.");

class TopicsPublisher implements PublisherInterface
{

    /**
     * @param TopicsAttributeKey $source
     * @param CoreAttributeKey $destination
     */
    public function publish(AttributeKey $source, CoreAttributeKey $destination)
    {
        $controller = $destination->getController();
        $name = (string) $source->getTreeName();
        $tree = \Concrete\Core\Tree\Type\Topic::getByName($name);
        $node = $tree->getNodeByDisplayPath($source->getNodePath());
        $controller->setNodes($node->getTreeNodeID(), $tree->getTreeID());
    }
}
