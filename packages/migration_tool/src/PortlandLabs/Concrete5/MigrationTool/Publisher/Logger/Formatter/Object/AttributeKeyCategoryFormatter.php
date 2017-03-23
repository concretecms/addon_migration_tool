<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\Formatter\Object;

use HtmlObject\Link;
use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Object\LoggableObject;

defined('C5_EXECUTE') or die("Access Denied.");

class AttributeKeyCategoryFormatter extends AbstractStandardFormatter
{

    public function getSkippedDescription(LoggableObject $object)
    {
        return t('Attribute key category %s already exists.', $object->getHandle());
    }

    public function getPublishedDescription(LoggableObject $object)
    {
        return t('Attribute key category %s published.', $object->getHandle());
    }


}
