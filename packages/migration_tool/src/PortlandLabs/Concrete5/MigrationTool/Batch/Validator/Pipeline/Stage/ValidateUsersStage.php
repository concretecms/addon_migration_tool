<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Pipeline\Stage;

use League\Pipeline\StageInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\TargetItemList;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\User;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Message;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\UnmappedTargetItem;

defined('C5_EXECUTE') or die("Access Denied.");

class ValidateUsersStage implements StageInterface
{
    public function __invoke($result)
    {
        $subject = $result->getSubject();
        $batch = $subject->getBatch();
        $page = $subject->getObject();

        if ($page->getUser()) {
            $mapper = new User();
            $targetItemList = new TargetItemList($batch, $mapper);
            $item = new Item($page->getUser());
            $targetItem = $targetItemList->getSelectedTargetItem($item);
            if ($targetItem instanceof UnmappedTargetItem) {
                $result->getMessages()->add(
                    new Message(t('User <strong>%s</strong> does not exist.', $item->getIdentifier()))
                );
            }
        }

        return $result;
    }

}
