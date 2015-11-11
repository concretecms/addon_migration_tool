<?php

namespace PortlandLabs\Concrete5\MigrationTool\Exporter\Item\Type;

use Concrete\Core\Support\Manager as CoreManager;

defined('C5_EXECUTE') or die("Access Denied.");

class Manager extends CoreManager
{

    protected function createBlockTypeDriver()
    {
        return new BlockType();
    }

    protected function createAttributeKeyDriver()
    {
        return new AttributeKey();
    }

    protected function createJobDriver()
    {
        return new Job();
    }

    protected function createSinglePageDriver()
    {
        return new SinglePage();
    }

    protected function createThemeDriver()
    {
        return new Theme();
    }

    protected function createPageTemplateDriver()
    {
        return new PageTemplate();
    }

    protected function createPageTypeDriver()
    {
        return new PageType();
    }

    public function __construct()
    {
        $this->driver('attribute_key');
        $this->driver('block_type');
        $this->driver('job');
        $this->driver('single_page');
        $this->driver('page_type');
        $this->driver('page_template');
        $this->driver('theme');
    }
}
