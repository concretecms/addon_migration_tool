<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Page\Validator\Content;

use Concrete\Core\Backup\ContentImporter\ValueInspector\Item\ItemInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Message;
use PortlandLabs\Concrete5\MigrationTool\Batch\Page\Validator\ValidatorTarget;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

class PageItemValidator implements ValidatorInterface
{
    public function itemExists(ItemInterface $item, Batch $batch)
    {
        if (is_object($item->getContentObject())) {
            return true;
        }

        foreach($batch->getPages() as $page) {
            if ($page->getBatchPath() == $item->getFieldValue()) {
                return true;
            }
        }
    }

    public function addMissingItemMessage(ItemInterface $item, ValidatorTarget $target)
    {
        $target->addMessage(
            new Message(t('Referenced page at path %s cannot be found in the site or in the current content batch.', $item->getReference()))
        );
    }




}