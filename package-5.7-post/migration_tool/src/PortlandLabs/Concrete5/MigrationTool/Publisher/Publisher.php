<?php

namespace PortlandLabs\Concrete5\MigrationTool\Publisher;

use Concrete\Core\Attribute\Key\CollectionKey;
use Concrete\Core\Block\BlockType\BlockType;
use Concrete\Core\Page\Template;
use Concrete\Core\Page\Type\Composer\FormLayoutSetControl;
use Concrete\Core\Page\Type\Type;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\TargetItemList;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\IgnoredTargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\UnmappedTargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

class Publisher
{
    protected $batch;

    public function __construct(Batch $batch)
    {
        $this->batch = $batch;
        $this->package = \Package::getByHandle('migration_tool');
    }

    protected function getTargetItem($mapper, $subject)
    {
        if ($subject) {
            $mappers = \Core::make('migration/manager/mapping');
            $mapper = $mappers->driver($mapper);
            $list = new TargetItemList($this->batch, $mapper);
            $item = new Item($subject);
            $targetItem = $list->getSelectedTargetItem($item);
            if (!($targetItem instanceof UnmappedTargetItem || $targetItem instanceof IgnoredTargetItem)) {
                return $mapper->getTargetItemContentObject($targetItem);
            }
        }
    }

    public function createInterimPages()
    {

        $db = \Database::connection();

        // First, create the top level page for the batch.
        $batches = \Page::getByPath('/!import_batches');
        $type = Type::getByHandle('import_batch');
        $batchParent = $batches->add($type, array(
            'cName' => $this->batch->getID(),
            'cHandle' => $this->batch->getID(),
            'pkgID' => $this->package->getPackageID()
        ));

                // Now loop through all pages, and build them
        foreach($this->batch->getPagesOrderedForImport() as $page) {

            $data = array();
            $ui = $this->getTargetItem('user', $page->getUser());
            if ($ui != '') {
                $data['uID'] = $ui->getUserID();
            } else {
                $data['uID'] = USER_SUPER_ID;
            }
            $cDatePublic = $page->getPublicDate();
            if ($cDatePublic) {
                $data['cDatePublic'] = $cDatePublic;
            }

            $type = $this->getTargetItem('page_type', $page->getType());
            if ($type) {
                $data['ptID'] = $type->getPageTypeID();
            }
            $template = $this->getTargetItem('page_template', $page->getTemplate());
            if (is_object($template)) {
                $data['pTemplateID'] = $template->getPageTemplateID();
            }
            if ($page->getBatchPath() != '') {
                $lastSlash = strrpos($page->getBatchPath(), '/');
                $parentPath = substr($page->getBatchPath(), 0, $lastSlash);
                $data['cHandle'] = substr($page->getBatchPath(), $lastSlash + 1);
                if (!$parentPath) {
                    $parent = $batchParent;
                } else {
                    $parent = \Page::getByPath('/!import_batches/' . $this->batch->getID() . $parentPath);
                }
            } else {
                $parent = $batchParent;
            }

            $data['name'] = $page->getName();
            $data['description'] = $page->getDescription();
            $concretePage = $parent->add($type, $data);

            foreach($page->attributes as $attribute) {
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
            $controlHandles = array_map(function($a) {
                return $a->getItemID();
            }, $controls);
            $blockSubstitutes = array();
            // Now we have our $controls array which we will use to determine if any of the blocks on this page
            // need to be replaced by another block.

            foreach($page->areas as $area) {
                foreach($area->blocks as $block) {
                    $bt = $this->getTargetItem('block_type', $block->getType());
                    if (is_object($bt)) {
                        $value = $block->getBlockValue();
                        $publisher = $value->getPublisher();
                        $b = $publisher->publish($bt, $concretePage, $area, $value);
                        if (in_array($bt->getBlockTypeHandle(), $controlHandles)) {
                            $blockSubstitutes[$bt->getBlockTypeHandle()] = $b;
                        }
                    }
                }
            }

            // Loop through all the blocks on the page. If any of them are composer output content blocks
            // We look in our composer mapping.
            foreach($concretePage->getBlocks() as $b) {
                if ($b->getBlockTypeHandle() == BLOCK_HANDLE_PAGE_TYPE_OUTPUT_PROXY) {
                    foreach($controls as $targetItem) {
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