<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use Concrete\Core\Page\Type\Composer\FormLayoutSetControl;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

class PublishPageContentRoutine extends AbstractPageRoutine
{
    public function execute(Batch $batch)
    {
        $this->batch = $batch;

        $pages = $this->getPagesOrderedForImport($batch);

        if (!$pages) {
            return;
        }

        foreach ($pages as $page) {
            $concretePage = $this->getPageByPath($batch, $page->getBatchPath());

            foreach ($page->attributes as $attribute) {
                $ak = $this->getTargetItem('attribute', $attribute->getAttribute()->getHandle());
                if (is_object($ak)) {
                    $value = $attribute->getAttribute()->getAttributeValue();
                    $publisher = $value->getPublisher();
                    $publisher->publish($ak, $concretePage, $value);
                }
            }

            $em = \ORM::entityManager("migration_tool");
            $r = $em->getRepository('\PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\TargetItem');
            $controls = $r->findBy(array('item_type' => 'composer_output_content'));
            $controlHandles = array_map(function ($a) {
                return $a->getItemID();
            }, $controls);
            $blockSubstitutes = array();
            // Now we have our $controls array which we will use to determine if any of the blocks on this page
            // need to be replaced by another block.

            foreach ($page->areas as $area) {
                $styleSet = $area->getStyleSet();
                if (is_object($styleSet)) {
                    $styleSetPublisher = $styleSet->getPublisher();
                    $publishedStyleSet = $styleSetPublisher->publish();
                    $concreteArea = \Area::getOrCreate($concretePage, $area->getName());
                    $concretePage->setCustomStyleSet($concreteArea, $publishedStyleSet);
                }
                foreach ($area->blocks as $block) {
                    $bt = $this->getTargetItem('block_type', $block->getType());
                    if (is_object($bt)) {
                        $value = $block->getBlockValue();
                        $publisher = $value->getPublisher();
                        $b = $publisher->publish($batch, $bt, $concretePage, $area, $value);
                        $styleSet = $block->getStyleSet();
                        if (is_object($styleSet)) {
                            $styleSetPublisher = $styleSet->getPublisher();
                            $publishedStyleSet = $styleSetPublisher->publish();
                            $b->setCustomStyleSet($publishedStyleSet);
                        }
                        if ($block->getCustomTemplate()) {
                            $b->setCustomTemplate($block->getCustomTemplate());
                        }

                        if (in_array($bt->getBlockTypeHandle(), $controlHandles)) {
                            $blockSubstitutes[$bt->getBlockTypeHandle()] = $b;
                        }
                    }
                }
            }

            // Loop through all the blocks on the page. If any of them are composer output content blocks
            // We look in our composer mapping.
            foreach ($concretePage->getBlocks() as $b) {
                if ($b->getBlockTypeHandle() == BLOCK_HANDLE_PAGE_TYPE_OUTPUT_PROXY) {
                    foreach ($controls as $targetItem) {
                        if ($targetItem->isMapped() && intval($targetItem->getSourceItemIdentifier()) == intval($b->getBlockID())) {
                            $substitute = $blockSubstitutes[$targetItem->getItemID()];
                            if ($substitute) {
                                // We move the substitute to where the proxy block was.
                                $blockDisplayOrder = $b->getBlockDisplayOrder();
                                $substitute->setAbsoluteBlockDisplayOrder($blockDisplayOrder);
                                $control = $b->getController()->getComposerOutputControlObject();
                                if (is_object($control)) {
                                    $control = FormLayoutSetControl::getByID($control->getPageTypeComposerFormLayoutSetControlID());
                                    if (is_object($control)) {
                                        $blockControl = $control->getPageTypeComposerControlObject();
                                        if (is_object($blockControl)) {
                                            $blockControl->recordPageTypeComposerOutputBlock($substitute);
                                        }
                                    }
                                }
                            }
                        }
                    }
                    // we delete the proxy block
                    $b->deleteBlock();
                }
            }
        }
    }
}
