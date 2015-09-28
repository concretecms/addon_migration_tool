<?php

namespace PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Formatter;

defined('C5_EXECUTE') or die("Access Denied.");

class PageTemplateFormatter extends AbstractFormatter
{

    public function getPluralDisplayName()
    {
        return t('Page Templates');
    }
}

