<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper;

use Concrete\Core\Support\Manager as CoreManager;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\Attribute;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\ComposerOutputContent;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\PageTemplate;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\PageType;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\User;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\BlockType;

defined('C5_EXECUTE') or die("Access Denied.");

class Manager extends CoreManager
{

    protected function createAttributeDriver()
    {
        return new Attribute();
    }

    protected function createPageTemplateDriver()
    {
        return new PageTemplate();
    }

    protected function createPageTypeDriver()
    {
        return new PageType();
    }

    protected function createUserDriver()
    {
        return new User();
    }

    protected function createBlockTypeDriver()
    {
        return new BlockType();
    }

    protected function createComposerOutputContentDriver()
    {
        return new ComposerOutputContent();
    }

    public function __construct()
    {
        $this->driver('attribute');
        $this->driver('page_template');
        $this->driver('page_type');
        $this->driver('user');
        $this->driver('block_type');
        $this->driver('composer_output_content');
    }
}
