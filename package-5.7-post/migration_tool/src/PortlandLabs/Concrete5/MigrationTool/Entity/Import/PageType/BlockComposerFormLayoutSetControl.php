<?php

namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageType;

use Doctrine\Common\Collections\ArrayCollection;


/**
 * @Entity
 */
class BlockComposerFormLayoutSetControl extends ComposerFormLayoutSetControl
{

    public function getHandle()
    {
        return 'block';
    }

}
