<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\AttributeKey;

use Concrete\Core\Attribute\Key\Key as CoreAttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\TextAreaAttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKey;

defined('C5_EXECUTE') or die("Access Denied.");

class TextAreaPublisher implements PublisherInterface
{
    /**
     * @param TextAreaAttributeKey $source
     * @param CoreAttributeKey $destination
     */
    public function publish(AttributeKey $source, CoreAttributeKey $destination)
    {
        $controller = $destination->getController();
        $data = array();
        $data['akTextareaDisplayMode'] = $source->getMode();
        $controller->saveKey($data);
    }
}
