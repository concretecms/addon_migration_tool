<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\Express;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\ExpressEntity\Control\AssociationFormatter;
/**
 * @ORM\Entity
 */
class AssociationControl extends Control
{

    /**
     * @ORM\Column(type="string")
     */
    protected $association;

    /**
     * @return mixed
     */
    public function getAssociation()
    {
        return $this->association;
    }

    /**
     * @param mixed $association
     */
    public function setAssociation($association)
    {
        $this->association = $association;
    }

    public function getFormatter()
    {
        return new AssociationFormatter($this);
    }


}
