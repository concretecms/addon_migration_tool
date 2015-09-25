<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Page\Validator\Content;

use Concrete\Core\Backup\ContentImporter\ValueInspector\Item\ItemInterface;
use Concrete\Core\Backup\ContentImporter\ValueInspector\Item\PageItem;

defined('C5_EXECUTE') or die("Access Denied.");

class Factory
{

    protected $validator;

    public function __construct(ItemInterface $item)
    {

        if ($item instanceof PageItem) {
            $this->validator = new PageItemValidator();
        }

        if (!$this->validator) {
            $this->validator = new StandardItemValidator();
        }
    }

    public function getValidator()
    {
        return $this->validator;
    }

}