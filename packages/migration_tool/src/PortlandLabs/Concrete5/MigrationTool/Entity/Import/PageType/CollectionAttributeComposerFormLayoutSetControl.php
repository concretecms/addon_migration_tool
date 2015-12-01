<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageType;

use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\PageType\CollectionAttributeComposerFormLayoutSetControlValidator;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

/**
 * @Entity
 */
class CollectionAttributeComposerFormLayoutSetControl extends ComposerFormLayoutSetControl
{
    public function getHandle()
    {
        return 'collection_attribute';
    }

    public function getRecordValidator(Batch $batch)
    {
        return new CollectionAttributeComposerFormLayoutSetControlValidator($batch);
    }
}
