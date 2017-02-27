<?php

namespace PortlandLabs\Concrete5\MigrationTool\Publisher\AttributeKey;

use Concrete\Core\Entity\Attribute\Key\Type\BooleanType;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\BooleanAttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKey;

defined('C5_EXECUTE') or die('Access Denied.');

class BooleanPublisher extends AbstractPublisher
{
    /**
     * @param BooleanAttributeKey $source
     */
    public function publish(AttributeKey $source, $destination)
    {
        if (class_exists('\Concrete\Core\Entity\Attribute\Key\Type\Type')) {
            // version 8
            $key_type = new BooleanType();
            $key_type->setIsCheckedByDefault($source->getIsChecked());

            return $this->publishAttribute($source, $key_type, $destination);
        } else {
            $controller = $destination->getController();
            $data = array();
            $data['akCheckedByDefault'] = $source->getIsChecked();
            $controller->saveKey($data);
        }
    }
}
