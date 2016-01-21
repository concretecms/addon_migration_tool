<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\AttributeKey;

use Concrete\Core\Attribute\Controller;
use Concrete\Core\Attribute\Type;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\TextAreaAttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKey;

defined('C5_EXECUTE') or die("Access Denied.");

class StandardPublisher extends AbstractPublisher
{
    public function publish(AttributeKey $source, $destination)
    {
        $type = Type::getByHandle($source->getType());
        /**
         * @var $controller Controller
         */
        $controller = $type->getController();
        if (class_exists('\Concrete\Core\Entity\Attribute\Key\Type\Type')) {
            // version 8
            $key_type = $controller->getAttributeKeyType();
            return $this->publishAttribute($source, $key_type, $destination);
        }
    }
}
