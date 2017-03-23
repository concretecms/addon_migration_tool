<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\Formatter\Object;

use HtmlObject\Link;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockType;
use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Object\LoggableObject;

defined('C5_EXECUTE') or die("Access Denied.");

class PageFormatter extends AbstractStandardFormatter
{

    public function getSkippedDescription(LoggableObject $object)
    {
        return t('Page %s (Path: %s) already exists.', $object->getName(), $object->getBatchPath());
    }

    public function getPublishedDescription(LoggableObject $object)
    {
        return t('Page %s (Path: %s) created.', $object->getName(), $object->getBatchPath());
    }


}
