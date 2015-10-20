<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\PageType;

use Concrete\Core\Backup\ContentImporter\ValueInspector\Item\PageTemplateItem;
use Concrete\Core\Backup\ContentImporter\ValueInspector\ValueInspector;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\AbstractValidator;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ItemValidatorInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Message;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\MessageCollection;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page\Content\Factory;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page\Content\PageTemplateItemValidator;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageType\PageType;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Validator\PageTemplateValidator;

defined('C5_EXECUTE') or die("Access Denied.");

class Validator extends AbstractValidator
{

    /**
     * @param \PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageType\PageType
     * @return MessageCollection
     */
    public function validate($type)
    {
        $collection = new MessageCollection();
        $target = $type->getPublishTarget();
        $validator = $target->getRecordValidator($this->getBatch());
        $messages = $validator->validate($target);
        if (is_object($messages) && count($messages)) {
            foreach($messages as $msg) {
                $collection->add($msg);
            }
        }

        $templates = array();
        if ($template = $type->getDefaultTemplate()) {
            $templates[] = $template;
        }
        if ($type->getAllowedTemplates() == 'C') {
            foreach($type->getTemplates() as $template) {
                if (!in_array($template, $templates)) {
                    $templates[] = $template;
                }
            }
        }

        $validator = new PageTemplateItemValidator();
        foreach($templates as $template) {
            $item = new PageTemplateItem($template);
            if (!$validator->itemExists($item, $this->getBatch())) {
                $validator->addMissingItemMessage($item, $collection);
            }
        }

        // Validate the page type defaults
        $defaultPages = $type->getDefaultPageCollection();
        $pageValidator = $defaultPages->getRecordValidator($this->getBatch());
        foreach($defaultPages->getPages() as $page) {
            $pageMessages = $pageValidator->validate($page);
            if (is_object($pageMessages)) {
                $collection = new MessageCollection(array_unique(
                    array_merge($collection->toArray(), $pageMessages->toArray())
                ));
            }
        }

        return $collection;
    }
}