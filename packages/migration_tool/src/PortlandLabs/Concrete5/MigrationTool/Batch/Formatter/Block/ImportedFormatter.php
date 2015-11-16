<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\Block;

use HtmlObject\Element;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue\BlockValue;
use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\TreeContentItemFormatterInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class ImportedFormatter implements TreeContentItemFormatterInterface
{

    protected $value;

    public function getBatchTreeNodeJsonObject()
    {
        $node = new \stdClass;
        $node->title = $this->value->getBlock()->getType();
        $element = new Element('a', t('XML Element'), array('href' => '#'));
        $node->itemvalue = (string) $element;
        $node->iconclass = 'fa fa-cog';
        return $node;
    }

    public function __construct(BlockValue $value)
    {
        $this->value = $value;
    }


}
