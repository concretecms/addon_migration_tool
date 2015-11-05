<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type;

use Concrete\Core\Page\Type\Type;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\ComposerOutputContentItem;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\ItemInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\MapperInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\TargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\TargetItemInterface;
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

    public function getPageTypeComposerOutputContentItems(Type $type)
    {
        $items = array();
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
        return $items;
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
        $handles = array();
        foreach($types as $type) {
            if (!in_array($type->getItemID(), $handles)) {
                $handles[] = $type->getItemID();
            }
        }
        foreach($handles as $handle) {
            $type = Type::getByHandle($handle);
            if (is_object($type)) {
                $items = array_merge($items, $this->getPageTypeComposerOutputContentItems($type));
            }
        }
        return $items;
    }

    public function getMatchedTargetItem(Batch $batch, ItemInterface $item)
    {
        return false;
    }

    public function getTargetItemContentObject(TargetItemInterface $targetItem)
    {
        return false;
    }


    public function getBatchTargetItems(Batch $batch)
    {
        return array();
    }

    public function getInstalledTargetItems(Batch $batch)
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

    }
}