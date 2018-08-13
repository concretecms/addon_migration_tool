<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageType;

use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Object\CollectionAttributeComposerFormLayoutSetControlValidator;
use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class CollectionAttributeComposerFormLayoutSetControl extends ComposerFormLayoutSetControl
{
    public function getHandle()
    {
        return 'collection_attribute';
    }

    public function getRecordValidator(BatchInterface $batch)
    {
        return new CollectionAttributeComposerFormLayoutSetControlValidator($batch);
    }
}
