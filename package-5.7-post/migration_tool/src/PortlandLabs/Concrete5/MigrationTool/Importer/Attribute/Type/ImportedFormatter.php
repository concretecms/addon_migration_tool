<?php

namespace PortlandLabs\Concrete5\MigrationTool\Importer\Attribute\Type;

use HtmlObject\Element;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue;

defined('C5_EXECUTE') or die("Access Denied.");

class ImportedFormatter implements FormatterInterface
{

    protected $value;

    public function getIconClass()
    {
        return 'fa fa-cog';
    }

    public function getBatchTreeElementObject()
    {
        $content = new Element('span', $this->value->getAttribute()->getHandle());
        return $content;
    }

    public function __construct(AttributeValue $value)
    {
        $this->value = $value;
    }


}
