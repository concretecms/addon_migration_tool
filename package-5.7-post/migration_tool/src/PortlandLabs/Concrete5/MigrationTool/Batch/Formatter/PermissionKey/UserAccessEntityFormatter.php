<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\PermissionKey;

use HtmlObject\Element;
use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\TreeContentItemFormatterInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Permission\AccessEntity;

defined('C5_EXECUTE') or die("Access Denied.");

class UserAccessEntityFormatter extends AccessEntityFormatter
{

    public function getBatchTreeNodeJsonObject()
    {
        $node = new \stdClass;
        $node->title = t('User');
        $node->itemvalue = $this->entity->getUserName();
        return $node;
    }


}
