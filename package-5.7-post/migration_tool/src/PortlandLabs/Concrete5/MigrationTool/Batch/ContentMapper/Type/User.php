<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type;

use Concrete\Core\User\Event\UserInfo;
use Concrete\Core\User\UserList;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\ItemInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\MapperInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\TargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

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

    public function getItems(Batch $batch)
    {
        $users = array();
        foreach($batch->getPages() as $page) {
            if ($page->getUser() && !in_array($page->getUser(), $users)) {
                $users[] = $page->getUser();
            }
        }
        $items = array();
        foreach($users as $user) {
            $item = new Item();
            $item->setIdentifier($user);
            $items[] = $item;
        }
        return $items;
    }

    public function getMatchedTargetItem(ItemInterface $item)
    {
        $user = UserInfo::getByUserName($item->getIdentifier());
        if (is_object($user)) {
            $targetItem = new TargetItem($this);
            $targetItem->setItemId($user->getUserID());
            $targetItem->setItemName($user->getUserDisplayName());
            return $targetItem;
        }
    }

    public function getTargetItems()
    {
        $ul = new UserList();
        $ul->sortByUserName();
        $users = $ul->getResults();
        $items = array();
        foreach($users as $user) {
            $item = new TargetItem($this);
            $item->setItemId($user->getUserID());
            $item->setItemName($user->getUserDisplayName());
            $items[] = $item;
        }
        return $items;
    }


}