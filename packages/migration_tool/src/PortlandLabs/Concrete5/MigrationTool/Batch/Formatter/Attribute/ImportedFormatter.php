<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\Attribute;

use HtmlObject\Element;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\AttributeValue;
use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\TreeContentItemFormatterInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class ImportedFormatter implements TreeContentItemFormatterInterface
{
    protected $value;

    public function getBatchTreeNodeJsonObject()
    {
        $node = new \stdClass();
        $node->title = $this->value->getAttribute()->getHandle();
        $node->itemvalue = (string) $this->getColumnValue();
        $node->iconclass = 'fa fa-cog';

        return $node;
    }

    protected function getColumnValue()
    {
        $span = new Element('span');
        $link = new Element('a', t('XML Element'), array('href' => '#'));
        $tooltip = new Element('i', '', array('class' => 'launch-tooltip fa fa-question-circle', 'title' => t('Raw CIF XML Imported because this attribute is not installed or mapped to an existing attribute.')));
        $span->appendChild($link);
        $span->appendChild($tooltip);

        return $span;
    }

    public function __construct(AttributeValue $value)
    {
        $this->value = $value;
    }
}
