<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\AreaLayout;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Entity
 */
class CustomAreaLayoutColumn extends AreaLayoutColumn
{
    /**
     * @Column(type="integer")
     */
    protected $width = 0;

    /**
     * @return mixed
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param mixed $width
     */
    public function setWidth($width)
    {
        $this->width = $width;
    }
}
