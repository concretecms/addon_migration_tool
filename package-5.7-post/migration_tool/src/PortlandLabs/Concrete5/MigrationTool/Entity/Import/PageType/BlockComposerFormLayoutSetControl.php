<?php

namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageType;

use Doctrine\Common\Collections\ArrayCollection;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\PageType\BlockComposerFormLayoutSetControlValidator;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;


/**
 * @Entity
 */
class BlockComposerFormLayoutSetControl extends ComposerFormLayoutSetControl
{

    public function getHandle()
    {
        return 'block';
    }

    public function getRecordValidator(Batch $batch)
    {
        return new BlockComposerFormLayoutSetControlValidator($batch);
    }


}
