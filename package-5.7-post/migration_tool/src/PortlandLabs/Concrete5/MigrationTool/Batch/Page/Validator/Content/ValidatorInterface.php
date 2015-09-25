<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Page\Validator\Content;

use PortlandLabs\Concrete5\MigrationTool\Batch\Page\Validator\ValidatorTarget;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use Concrete\Core\Backup\ContentImporter\ValueInspector\Item\ItemInterface;

defined('C5_EXECUTE') or die("Access Denied.");

interface ValidatorInterface
{

    public function itemExists(ItemInterface $item, Batch $batch);
    public function addMissingItemMessage(ItemInterface $item, ValidatorTarget $target);

}