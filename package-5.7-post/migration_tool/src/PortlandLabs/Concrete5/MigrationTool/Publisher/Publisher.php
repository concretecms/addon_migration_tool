<?php

namespace PortlandLabs\Concrete5\MigrationTool\Publisher;

use Concrete\Core\Attribute\Key\CollectionKey;
use Concrete\Core\Block\BlockType\BlockType;
use Concrete\Core\Page\Template;
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

            foreach($page->areas as $area) {
                foreach($area->blocks as $block) {
                    $bt = $this->getTargetItem('block_type', $block->getType());
                    if (is_object($bt)) {
                        $value = $block->getBlockValue();
                        $publisher = $value->getPublisher();
                        $publisher->publish($bt, $concretePage, $area, $value);
                    }
                }
            }
        }

    }
}