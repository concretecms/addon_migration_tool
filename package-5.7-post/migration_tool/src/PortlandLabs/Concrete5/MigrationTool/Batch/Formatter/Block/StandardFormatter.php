<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\Block;

use HtmlObject\Element;

defined('C5_EXECUTE') or die("Access Denied.");

class StandardFormatter extends ImportedFormatter
{

    public function getBatchTreeNodeJsonObject()
    {
        $node = new \stdClass;
        $node->title = $this->value->getBlock()->getType();
        $node->iconclass = 'fa fa-cog';
        $node->children = array();
        foreach($this->value->getData() as $key => $value) {
            $child = new \stdClass;
            $child->title = $key;
            $child->itemvalue = h($value);
            $node->children[] = $child;
        }
        return $node;
    }


}
