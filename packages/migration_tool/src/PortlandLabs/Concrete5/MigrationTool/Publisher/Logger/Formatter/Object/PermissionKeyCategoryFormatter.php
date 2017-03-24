<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\Formatter\Object;

use HtmlObject\Link;
use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Object\LoggableObject;

defined('C5_EXECUTE') or die("Access Denied.");

class PermissionKeyCategoryFormatter extends AbstractStandardFormatter
{

    public function getSkippedDescription(LoggableObject $object)
    {
        return t('Permission key category %s already exists.', $object->getHandle());
    }

    public function getPublishedDescription(LoggableObject $object)
    {
        return t('Permission key category %s published.', $object->getHandle());
    }


}
