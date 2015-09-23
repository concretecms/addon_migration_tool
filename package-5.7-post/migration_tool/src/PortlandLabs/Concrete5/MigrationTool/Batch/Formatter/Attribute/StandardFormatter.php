<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\Attribute;

use HtmlObject\Element;

defined('C5_EXECUTE') or die("Access Denied.");

class StandardFormatter extends ImportedFormatter
{

    protected function getColumnValue()
    {
        return h($this->value->getValue());
    }

}