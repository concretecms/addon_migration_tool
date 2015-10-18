<?php

namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageType;

use Doctrine\Common\Collections\ArrayCollection;


/**
 * @Entity
 */
class CorePagePropertyComposerFormLayoutSetControl extends ComposerFormLayoutSetControl
{

    public function getHandle()
    {
        return 'core_page_property';
    }


}
