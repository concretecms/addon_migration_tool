<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch;

use Concrete\Core\Attribute\Key\CollectionKey;
use Concrete\Core\Block\BlockType\BlockType;
use Concrete\Core\Page\Template;
use Concrete\Core\Page\Type\Type;
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
            $user = $page->getUser();
            if ($user != '') {
                $ui = \UserInfo::getByUserName($user);
                if (is_object($ui)) {
                    $data['uID'] = $ui->getUserID();
                } else {
                    $data['uID'] = USER_SUPER_ID;
                }
            }
            $cDatePublic = $page->getPublicDate();
            if ($cDatePublic) {
                $data['cDatePublic'] = $cDatePublic;
            }

            if ($page->getType()) {
                $type = Type::getByHandle($page->getType());
                if (is_object($type)) {
                    $data['ptID'] = $type->getPageTypeID();
                }
            }
            if ($page->getTemplate()) {
                $template = Template::getByHandle($page->getTemplate());
                if (is_object($template)) {
                    $data['pTemplateID'] = $template->getPageTemplateID();
                }
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
                $ak = CollectionKey::getByHandle($attribute->getAttribute()->getHandle());
                if (is_object($ak)) {
                    $node = simplexml_load_string($attribute->getAttribute()->getValueXml());
                    print $ak->getController()->importValue($node);
                    $concretePage->setAttribute($attribute->getAttribute()->getHandle(),
                        $ak->getController()->importValue($node));
                }
            }

            foreach($page->areas as $area) {
                foreach($area->blocks as $block) {
                    $bt = BlockType::getByHandle($block->getType());
                    if (is_object($bt)) {
                        $btc = $bt->getController();
                        $bx = simplexml_load_string($block->getDataXml());
                        $btc->import($concretePage, $area->getName(), $bx);
                    }
                }
            }
        }

    }
}