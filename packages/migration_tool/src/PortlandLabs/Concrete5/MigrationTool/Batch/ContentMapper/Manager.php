<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper;

use Concrete\Core\Support\Manager as CoreManager;
use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\Area;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\Attribute;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\ComposerOutputContent;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\PageTemplate;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\PageType;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\User;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\BlockType;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BatchTargetItem;

defined('C5_EXECUTE') or die('Access Denied.');

class Manager extends CoreManager implements MapperManagerInterface
{
    public function createTargetItemList(BatchInterface $batch, MapperInterface $mapper)
    {
        return new TargetItemList($batch, $mapper);
    }

    public function createBatchTargetItem()
    {
        return new BatchTargetItem();
    }

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

    protected function createAreaDriver()
    {
        return new Area();
    }

    public function __construct()
    {
        $this->driver('area');
        $this->driver('attribute');
        $this->driver('block_type');
        $this->driver('composer_output_content');
        $this->driver('page_template');
        $this->driver('page_type');
        $this->driver('user');
    }
}
