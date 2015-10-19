<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\PageType;

use HtmlObject\Element;
use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\TreeContentItemFormatterInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Permission\AccessEntity;

defined('C5_EXECUTE') or die("Access Denied.");

class AllPagesPublishTargetFormatter extends PublishTargetFormatter
{

    public function getBatchTreeNodeJsonObject()
    {
        return $this->deliverTreeNodeDataJsonObject();
    }

    public function getTreeNodeTitle()
    {
        return t('All Pages');
    }



}
