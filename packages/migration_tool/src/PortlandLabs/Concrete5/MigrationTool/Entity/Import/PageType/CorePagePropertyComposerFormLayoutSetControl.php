<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageType;

use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class CorePagePropertyComposerFormLayoutSetControl extends ComposerFormLayoutSetControl
{
    public function getHandle()
    {
        return 'core_page_property';
    }

    public function getRecordValidator(BatchInterface $batch)
    {
        return false;
    }
}
