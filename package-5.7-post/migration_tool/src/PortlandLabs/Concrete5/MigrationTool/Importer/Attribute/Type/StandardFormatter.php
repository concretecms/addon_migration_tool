<?php

namespace PortlandLabs\Concrete5\MigrationTool\Importer\Attribute\Type;

use HtmlObject\Element;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue;

defined('C5_EXECUTE') or die("Access Denied.");

class StandardFormatter extends ImportedFormatter
{

    public function getBatchTreeElementObject()
    {
        $content = new Element('span');
        $content->appendChild(
            new Element('div', $this->value->getAttribute()->getHandle(), array(
            'class' => 'migration-tree-page-column migration-tree-attribute-handle'
            ))
        );
        $content->appendChild(
            new Element('div', h($this->value->getValue()), array(
                'class' => 'migration-tree-page-column migration-tree-attribute-value'
            ))
        );
        return $content;
    }

}
