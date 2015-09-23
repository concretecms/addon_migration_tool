<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\Block;

use HtmlObject\Element;

defined('C5_EXECUTE') or die("Access Denied.");

class StandardFormatter extends ImportedFormatter
{


    public function getBatchTreeNodeElementObject()
    {
        $list = new Element('ul');
        foreach($this->value->getData() as $key => $value) {
            $content = new Element('span');
            $content->appendChild(
                new Element('div', $key, array(
                    'class' => 'migration-tree-page-column migration-tree-property-key'
                ))
            );
            $content->appendChild(
                new Element('div', h($value), array(
                    'class' => 'migration-tree-page-column migration-tree-property-value'
                ))
            );
            $item = new Element('li', $content, array('data-iconClass' => 'fa fa-cog'));
            $list->appendChild($item);
        }
        $wrapper = new Element('li', $this->value->getBlock()->getType(), array('data-iconClass' => 'fa fa-cog'));
        $wrapper->appendChild($list);
        return $wrapper;
    }

}
