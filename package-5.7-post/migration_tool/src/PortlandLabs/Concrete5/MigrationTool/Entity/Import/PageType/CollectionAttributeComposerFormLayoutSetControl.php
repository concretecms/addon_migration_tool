<?php

namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageType;

use Doctrine\Common\Collections\ArrayCollection;


/**
 * @Entity
 */
class CollectionAttributeComposerFormLayoutSetControl extends ComposerFormLayoutSetControl
{

    public function getHandle()
    {
        return 'collection_attribute';
    }

}
