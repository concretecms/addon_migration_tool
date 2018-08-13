<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\User\Task;

use League\Pipeline\StageInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\TargetItemList;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\UserGroup;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Message;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorResult;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\UnmappedTargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\User;

defined('C5_EXECUTE') or die("Access Denied.");

class ValidateUserGroupsStage implements StageInterface
{
    /**
     * @param $result ValidatorResult
     */
    public function __invoke($result)
    {
        $subject = $result->getSubject();
        $batch = $subject->getBatch();
        /**
         * @var $user User
         */
        $user = $subject->getObject();
        $userMapper = new UserGroup();
        $targetItemList = new TargetItemList($batch, $userMapper);
        foreach ($user->getGroups() as $group) {
            if ($group->getPath()) {
                $item = new Item($group->getPath());
            } else {
                $item = new Item('/' . $group->getName());
            }
            $targetItem = $targetItemList->getSelectedTargetItem($item);
            if ($targetItem instanceof UnmappedTargetItem) {
                $result->getMessages()->addMessage(
                    new Message(t('Group <strong>%s</strong> does not exist.', $item->getIdentifier()))
                );
            }
        }
    }

}
