<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page\Content;

use Concrete\Core\Backup\ContentImporter\ValueInspector\Item\ItemInterface;
use Concrete\Core\Backup\ContentImporter\ValueInspector\Item\PageItem;
use Concrete\Core\Backup\ContentImporter\ValueInspector\Item\PageTypeItem;

defined('C5_EXECUTE') or die("Access Denied.");

class Factory
{

    protected $validator;

    public function __construct(ItemInterface $item)
    {

        if ($item instanceof PageItem) {
            $this->validator = new PageItemValidator();
        }

        if ($item instanceof PageTypeItem) {
            $this->validator = new PageTypeItemValidator();
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