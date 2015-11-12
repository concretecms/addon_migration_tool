<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item;

use Concrete\Core\Support\Manager as CoreManager;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\Attribute;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\PageTemplate;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\PageType;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\User;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\BlockType;

defined('C5_EXECUTE') or die("Access Denied.");

class Item implements ItemInterface
{

    protected $identifier;
    protected $displayName;

    public function __construct($identifier = null)
    {
        $this->identifier = $identifier;
    }

    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }

    public function setDisplayName($name)
    {
        $this->displayName = $name;
    }

    public function getIdentifier()
    {
        return $this->identifier;
    }

    public function getDisplayName()
    {
        if ($this->displayName) {
            return $this->displayName;
        }
        return $this->getIdentifier();
    }


}
