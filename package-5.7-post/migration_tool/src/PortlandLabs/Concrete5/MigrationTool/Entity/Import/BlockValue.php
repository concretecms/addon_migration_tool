<?php

namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;

/**
 * @Entity
 * @Table(name="MigrationImportBlockValues")
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="value_type", type="string")
 * @DiscriminatorMap( {
 * "standard" = "StandardBlockValue",
 * "imported" = "ImportedBlockValue"} )
 */
abstract class BlockValue
{

    /**
     * @Id @Column(type="guid")
     * @GeneratedValue(strategy="UUID")
     */
    protected $id;


    /**
     * @OneToOne(targetEntity="\PortlandLabs\Concrete5\MigrationTool\Entity\Import\Block", mappedBy="block_value")
     **/
    protected $block;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getBlock()
    {
        return $this->block;
    }

    /**
     * @param mixed $block
     */
    public function setBlock($block)
    {
        $this->block = $block;
    }


    abstract public function getFormatter();
    abstract public function getPublisher();
    abstract public function getInspector();

}
