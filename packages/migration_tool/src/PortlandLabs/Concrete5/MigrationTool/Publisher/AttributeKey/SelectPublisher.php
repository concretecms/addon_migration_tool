<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\AttributeKey;

use Concrete\Core\Attribute\Key\Key as CoreAttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\SelectAttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKey;

defined('C5_EXECUTE') or die("Access Denied.");

class SelectPublisher implements PublisherInterface
{
    /**
     * @param SelectAttributeKey $source
     * @param CoreAttributeKey $destination
     */
    public function publish(AttributeKey $source, CoreAttributeKey $destination)
    {
        /**
         * @var \Concrete\Attribute\Select\Controller
         */
        $controller = $destination->getController();
        $controller->setAllowedMultipleValues($source->getAllowMultipleValues());
        $controller->setAllowOtherValues($source->getAllowOtherValues());
        $controller->setOptionDisplayOrder($source->getDisplayOrder());
        $options = array();
        foreach ($source->getOptions() as $option) {
            $options[] = $option['value'];
        }
        $controller->setOptions($options);
    }
}
