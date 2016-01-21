<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\AttributeKey;

use Concrete\Core\Attribute\Key\Key as CoreAttributeKey;
use Concrete\Core\Entity\Attribute\Key\Key;
use Concrete\Core\Entity\Attribute\Key\Type\SelectType;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\SelectAttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKey;

defined('C5_EXECUTE') or die("Access Denied.");

class SelectPublisher extends AbstractPublisher
{
    /**
     * @param SelectAttributeKey $source
     * @param CoreAttributeKey $destination
     */
    public function publish(AttributeKey $source, $destination)
    {
        if (class_exists('\Concrete\Core\Entity\Attribute\Key\Type\Type')) {
            // version 8
            $key_type = new SelectType();
            $key_type->setAllowMultipleValues($source->getAllowMultipleValues());
            $key_type->setAllowOtherValues($source->getAllowOtherValues());
            $key_type->setDisplayOrder($source->getDisplayOrder());
            return $this->publishAttribute($source, $key_type, $destination);
        } else {
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
}
