<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\Attribute;

use HtmlObject\Element;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue;
use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\TreeContentItemFormatterInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class ImportedFormatter implements TreeContentItemFormatterInterface
{

    protected $value;

    public function getBatchTreeNodeElementObject()
    {
        $content = new Element('span');
        $content->appendChild(
            new Element('div', $this->value->getAttribute()->getHandle(), array(
                'class' => 'migration-tree-page-column migration-tree-property-key'
            ))
        );
        $content->appendChild(
            new Element('div', $this->getColumnValue(), array(
                'class' => 'migration-tree-page-column migration-tree-property-value'
            ))
        );
        $element = new Element('li', $content, array('data-iconClass' => 'fa fa-cog'));
        return $element;
    }


    protected function getColumnValue()
    {
        return new Element('a', t('XML Element'), array('href' => '#'));
    }

    public function __construct(AttributeValue $value)
    {
        $this->value = $value;
    }


}
