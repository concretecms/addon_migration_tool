<?php

namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\AreaLayout;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="MigrationImportAreaLayouts")
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="type", type="string")
 */
abstract class AreaLayout
{
    /**
     * @Id @Column(type="guid")
     * @GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @OneToOne(targetEntity="\PortlandLabs\Concrete5\MigrationTool\Entity\Import\BLockValue\AreaLayoutBlockValue", mappedBy="area_layout")
     **/
    protected $block_value;

    /**
     * @OneToMany(targetEntity="AreaLayoutColumn", mappedBy="area_layout", cascade={"persist", "remove"})
     **/
    protected $columns;

    /**
     * @return mixed
     */
    public function getBlockValue()
    {
        return $this->block_value;
    }

    /**
     * @param mixed $block_value
     */
    public function setBlockValue($block_value)
    {
        $this->block_value = $block_value;
    }

    /**
     * @return AreaLayoutColumn[]
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * @param mixed $columns
     */
    public function setColumns($columns)
    {
        $this->columns = $columns;
    }

    public function __construct()
    {
        $this->columns = new ArrayCollection();
    }

    /**
     * @return \PortlandLabs\Concrete5\MigrationTool\Publisher\AreaLayout\PublisherInterface
     */
    abstract public function getPublisher();
}
