<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type;

use Concrete\Core\User\UserInfo;
use Concrete\Core\User\UserList;
use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\ItemInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\MapperInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\TargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\TargetItemInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class User implements MapperInterface
{
    public function getMappedItemPluralName()
    {
        return t('Users');
    }

    public function getHandle()
    {
        return 'user';
    }

    public function getItems(BatchInterface $batch)
    {
        $users = array();
        foreach ($batch->getPages() as $page) {
            if ($page->getUser() && !in_array($page->getUser(), $users)) {
                $users[] = $page->getUser();
            }
        }

        $pageTypes = $batch->getObjectCollection('page_type');
        if (is_object($pageTypes)) {
            foreach ($pageTypes->getTypes() as $type) {
                $defaults = $type->getDefaultPageCollection();
                foreach ($defaults->getPages() as $page) {
                    if ($page->getUser() && !in_array($page->getUser(), $users)) {
                        $users[] = $page->getUser();
                    }
                }
            }
        }

        $items = array();
        foreach ($users as $user) {
            $item = new Item();
            $item->setIdentifier($user);
            $items[] = $item;
        }

        return $items;
    }

    public function getMatchedTargetItem(BatchInterface $batch, ItemInterface $item)
    {
        $user = UserInfo::getByUserName($item->getIdentifier());
        if (is_object($user)) {
            $targetItem = new TargetItem($this);
            $targetItem->setItemId($user->getUserID());
            $targetItem->setItemName($user->getUserDisplayName());

            return $targetItem;
        }
    }

    public function getBatchTargetItems(BatchInterface $batch)
    {
        return array();
    }

    public function getCorePropertyTargetItems(BatchInterface $batch)
    {
        return array();
    }

    public function getInstalledTargetItems(BatchInterface $batch)
    {
        $ul = new UserList();
        $ul->sortByUserName();
        $users = $ul->getResults();
        $items = array();
        foreach ($users as $user) {
            $item = new TargetItem($this);
            $item->setItemId($user->getUserID());
            $item->setItemName($user->getUserDisplayName());
            $items[] = $item;
        }

        return $items;
    }

    public function getTargetItemContentObject(TargetItemInterface $targetItem)
    {
        return \UserInfo::getByID($targetItem->getItemID());
    }
}
