<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type;

use Concrete\Core\Page\Type\Type;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\ComposerOutputContentItem;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\ItemInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\MapperInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\TargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

class ComposerOutputContent implements MapperInterface
{

    public function getMappedItemPluralName()
    {
        return t('Composer Content');
    }

    public function getHandle()
    {
        return 'composer_output_content';
    }

    public function getItems(Batch $batch)
    {
        // first, loop through all the page types
        // that are mapped in the current content batch
        $db = \Database::connection();
        $em = $db->getEntityManager();
        $r = $em->getRepository('PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\TargetItem');
        $types = $r->findBy(array(
            'item_type' => 'page_type'
        ));

        $items = array();
        $ids = array();
        foreach($types as $type) {
            if (!in_array($type->getItemID(), $ids)) {
                $ids[] = $type->getItemID();
            }
        }
        foreach($ids as $id) {
            $type = Type::getByID($id);
            foreach($type->getPageTypePageTemplateObjects() as $template) {
                $c = $type->getPageTypePageTemplateDefaultPageObject($template);
                $blocks = $c->getBlocks();
                foreach($blocks as $b) {
                    if ($b->getBlockTypeHandle() == BLOCK_HANDLE_PAGE_TYPE_OUTPUT_PROXY) {
                        $item = new ComposerOutputContentItem($b);
                        $items[] = $item;
                    }
                }

            }
        }
        return $items;
    }

    public function getMatchedTargetItem(ItemInterface $item)
    {
        $bt = \Concrete\Core\Block\BlockType\BlockType::getByHandle($item->getIdentifier());
        if (is_object($bt)) {
            $targetItem = new TargetItem($this);
            $targetItem->setItemId($bt->getBlockTypeID());
            $targetItem->setItemName($bt->getBlockTypeName());
            return $targetItem;
        }
    }

    public function getTargetItems(Batch $batch)
    {

        $db = \Database::connection();
        $em = $db->getEntityManager();
        $query = $em->createQuery('select distinct b from \PortlandLabs\Concrete5\MigrationTool\Entity\Import\Block b
        group by b.type order by b.type asc');
        $types = $query->getResult();
        $items = array();
        foreach($types as $type) {
            $item = new TargetItem($this);
            $item->setItemId($type->getType());
            $item->setItemName($type->getType());
            $items[] = $item;
        }
        return $items;

        // We can use this code later when we actually do the mapping
        /*
        $items = $this->getItems($batch);
        $db = \Database::connection();
        $em = $db->getEntityManager();
        $rp = $em->getRepository('PortlandLabs\Concrete5\MigrationTool\Entity\Import\Page');
        $ra = $em->getRepository('PortlandLabs\Concrete5\MigrationTool\Entity\Import\Area');
        $ri = $em->getRepository('PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\TargetItem');

        foreach($items as $item) {
            $c = $item->getBlock()->getBlockCollectionObject();
            $type = $c->getPageTypeObject();
            // now that I have page types, I need to find all import records that are mapping
            // to this page type.
            $importPageTypes = $ri->findBy(array(
               'item_id' => $type->getPageTypeID(),
               'item_type' => 'page_type'
            ));
            foreach($importPageTypes as $importPageType) {
                $importPages = $rp->findByType($importPageType->getSourceItemIdentifier());
                foreach($importPages as $importPage) {
                    $areas = $importPage->getAreas();
                    foreach($areas as $area) {
                        foreach($area->getBlocks() as $block) {
                            var_dump_safe($block);
                        }
                    }
                }
            }
        }

        */

    }
}