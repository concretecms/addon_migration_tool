<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\AttributeKey;

use HtmlObject\Element;
use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\TreeContentItemFormatterInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKey;

defined('C5_EXECUTE') or die("Access Denied.");

class UnknownFormatter extends AbstractFormatter
{

    public function getBatchTreeNodeJsonObject()
    {
        return false;
    }


}
