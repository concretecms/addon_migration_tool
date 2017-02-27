<?php

namespace PortlandLabs\Concrete5\MigrationTool\Publisher\AttributeKey;

use Concrete\Core\Entity\Attribute\Key\Type\DateTimeType;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\DateTimeAttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKey;

defined('C5_EXECUTE') or die('Access Denied.');

class DateTimePublisher extends AbstractPublisher
{
    /**
     * @param DateTimeAttributeKey $source
     */
    public function publish(AttributeKey $source, $destination)
    {
        if (class_exists('\Concrete\Core\Entity\Attribute\Key\Type\Type')) {
            // version 8
            $key_type = new DateTimeType();
            $key_type->setMode($source->getMode());

            return $this->publishAttribute($source, $key_type, $destination);
        } else {
            $controller = $destination->getController();
            $data = array();
            $data['akDateDisplayMode'] = $source->getMode();
            $controller->saveKey($data);
        }
    }
}
