<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type;

use Concrete\Core\Attribute\Key\CollectionKey;
use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentTransformer\TransformableEntityMapperInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\ShortDescriptionTargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageType\CollectionAttributeComposerFormLayoutSetControl;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\ItemInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\MapperInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\TargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\TargetItemInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class EventAttribute extends Attribute
{

    public function getAttributeKeyCategoryHandle()
    {
        return 'event';
    }

    public function getMappedItemPluralName()
    {
        return t('Event Attributes');
    }

    public function getHandle()
    {
        return 'event_attribute';
    }

    public function getTransformableEntityObjects(BatchInterface $batch)
    {
        /**
         * @TODO MAKE THIS WORK
         */
        $attributes = array();
        /*
        $sites = $batch->getObjectCollection('site');
        if (is_object($sites)) {
            foreach($sites->getSites() as $site) {
                foreach ($site->getAttributes() as $attribute) {
                    if (is_object($attribute->getAttribute())) {
                        $attributes[] = $attribute->getAttribute();
                    }
                }
            }
        }
        */
        return $attributes;
    }


}
