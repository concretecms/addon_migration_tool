<?php

namespace PortlandLabs\Concrete5\MigrationTool\Importer\Formatter;

defined('C5_EXECUTE') or die("Access Denied.");

class CaptchaFormatter extends AbstractFormatter
{

    public function getPluralDisplayName()
    {
        return t('Captcha Libraries');
    }
}

