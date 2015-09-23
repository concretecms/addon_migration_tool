<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\Block;

use HtmlObject\Element;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue;
use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\TreeContentItemFormatterInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class ImportedFormatter implements TreeContentItemFormatterInterface
{

    protected $value;

    public function getBatchTreeNodeElementObject()
    {
        $content = new Element('span');
        $content->appendChild(
            new Element('div', $this->value->getBlock()->getType(), array(
                'class' => 'migration-tree-page-column migration-tree-property-key'
            ))
        );
        $element = new Element('a', t('XML Element'), array('href' => '#'));
        $content->appendChild(
            new Element('div', $element, array(
                'class' => 'migration-tree-page-column migration-tree-property-value'
            ))
        );
        $element = new Element('li', $content, array('data-iconClass' => 'fa fa-cog'));
        return $element;
    }


    public function __construct(BlockValue $value)
    {
        $this->value = $value;
    }


}
