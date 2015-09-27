<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Page\Validator\Task;

use Concrete\Core\Foundation\Processor\ActionInterface;
use Concrete\Core\Foundation\Processor\TaskInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\TargetItemList;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\Area;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\Attribute;
use PortlandLabs\Concrete5\MigrationTool\Batch\Page\Validator\Message;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\UnmappedTargetItem;

defined('C5_EXECUTE') or die("Access Denied.");

class ValidateAreasTask implements TaskInterface
{

    public function execute(ActionInterface $action)
    {
        // Grab the target item for the page's page type.
        $subject = $action->getSubject();
        $target = $action->getTarget();
        $areaMapper = new Area();
        $targetItemList = new TargetItemList($target->getBatch(), $areaMapper);
        foreach($subject->getAreas() as $area) {
            $item = new Item($area->getName());
            $targetItem = $targetItemList->getSelectedTargetItem($item);
            if ($targetItem instanceof UnmappedTargetItem) {
                $action->getTarget()->addMessage(
                    new Message(t('Area <strong>%s</strong> does not exist.', $item->getIdentifier()))
                );
            }
        }
    }

    public function finish(ActionInterface $action)
    {

    }

}
