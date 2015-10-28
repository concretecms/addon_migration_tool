<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item;

use Concrete\Core\Support\Manager as CoreManager;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\Attribute;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\PageTemplate;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\PageType;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\User;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\BlockType;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Block;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\MappedBlock;

defined('C5_EXECUTE') or die("Access Denied.");

class BlockItem implements ItemInterface
{

    protected $block;

    public function __construct(MappedBlock $block)
    {
        $this->block = $block;
    }

    public function getDisplayName()
    {
        if ($this->block->getType()) {
            return $this->block->getType();
        } else if ($this->block->getDefaultsOutputIdentifier()) {
            return t('Defaults Output: %s', $this->block->getDefaultsOutputIdentifier());
        }
    }

    public function getIdentifier()
    {
        return $this->block->getDefaultsOutputIdentifier() ? $this->block->getDefaultsOutputIdentifier() : $this->block->getType();
    }

}
