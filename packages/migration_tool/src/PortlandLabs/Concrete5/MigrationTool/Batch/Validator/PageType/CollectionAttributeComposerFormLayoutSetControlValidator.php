<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\PageType;

use Concrete\Core\User\Group\Group;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\TargetItemList;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\Attribute;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\AbstractValidator;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ItemValidatorInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Message;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\MessageCollection;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page\Content\PageTypeItemValidator;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\UnmappedTargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

class CollectionAttributeComposerFormLayoutSetControlValidator extends AbstractValidator
{

    public function validate($control)
    {
        $messages = new MessageCollection();
        $attributeMapper = new Attribute();
        $targetItemList = new TargetItemList($this->getBatch(), $attributeMapper);
        $item = new Item($control->getItemIdentifier());
        $targetItem = $targetItemList->getSelectedTargetItem($item);
        if ($targetItem instanceof UnmappedTargetItem) {
            $messages->add(
                new Message(t('Attribute <strong>%s</strong> does not exist in the current batch or in the site.', $item->getIdentifier()))
            );
        }
        return $messages;
    }


}