<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Object;

use Concrete\Core\Backup\ContentImporter\ValueInspector\Item\PageTemplateItem;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\TargetItemList;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\AbstractValidator;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\BatchObjectValidatorSubject;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Message;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\MessageCollection;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page\Content\PageTemplateItemValidator;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorResult;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorSubjectInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\UnmappedTargetItem;

defined('C5_EXECUTE') or die("Access Denied.");

class PageTypeValidator implements ValidatorInterface
{
    public function validate(ValidatorSubjectInterface $subject)
    {
        /**
         * @var $subject BatchObjectValidatorSubject
         */
        $batch = $subject->getBatch();
        $type = $subject->getObject();
        $result = new ValidatorResult($subject);

        foreach ($type->getLayoutSets() as $set) {
            foreach ($set->getControls() as $control) {
                $validator = $control->getRecordValidator($batch);
                if (is_object($validator)) {
                    $subject = new BatchObjectValidatorSubject($batch, $control);
                    $r = $validator->validate($subject);
                    $result->getMessages()->addMessages($r->getMessages());
                }
            }
        }

        // Validate the page publish targets
        $target = $type->getPublishTarget();
        $validator = $target->getRecordValidator($batch);
        if (is_object($validator)) {
            $subject = new BatchObjectValidatorSubject($batch,  $target);
            $r = $validator->validate($subject);
            $result->getMessages()->addMessages($r->getMessages());
        }

        // Validate the page templates
        $templates = array();
        if ($template = $type->getDefaultTemplate()) {
            $templates[] = $template;
        }
        if ($type->getAllowedTemplates() == 'C') {
            foreach ($type->getTemplates() as $template) {
                if (!in_array($template, $templates)) {
                    $templates[] = $template;
                }
            }
        }

        $validator = new PageTemplateItemValidator();
        foreach ($templates as $template) {
            $item = new PageTemplateItem($template);
            if (!$validator->itemExists($item, $batch)) {
                $validator->addMissingItemMessage($item, $result->getMessages());
            }
        }

        // Validate the page type defaults
        $defaultPages = $type->getDefaultPageCollection();
        $pageValidator = $defaultPages->getRecordValidator($batch);
        foreach ($defaultPages->getPages() as $page) {
            $subject = new BatchObjectValidatorSubject($batch,  $page);
            $pageMessages = $pageValidator->validate($subject);
            if (is_object($pageMessages)) {
                $result->getMessages()->addMessages($pageMessages->getMessages());
            }
        }

        return $result;
    }
}
