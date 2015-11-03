<?php

namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;
/** @MappedSuperclass */
class MappedBlock
{

    /**
     * @Id @Column(type="guid")
     * @GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @Column(type="string", nullable=true)
     */
    protected $type = null;

    /**
     * @Column(type="string", nullable=true)
     */
    protected $name;

    /**
     * @OneToOne(targetEntity="\PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue", inversedBy="block", cascade={"persist", "remove"})
     **/
    protected $block_value;

    /**
     * @Column(type="integer")
     */
    protected $position = 0;

    /**
     * @ManyToOne(targetEntity="Area")
     **/
    protected $area;

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
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getArea()
    {
        return $this->area;
    }

    /**
     * @param mixed $area
     */
    public function setArea($area)
    {
        $this->area = $area;
    }


    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param mixed $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

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
     * @Column(type="string", nullable=true)
     */
    protected $defaults_output_identifier = null;

    /**
     * @return mixed
     */
    public function getDefaultsOutputIdentifier()
    {
        return $this->defaults_output_identifier;
    }

    /**
     * @param mixed $defaults_output_identifier
     */
    public function setDefaultsOutputIdentifier($defaults_output_identifier)
    {
        $this->defaults_output_identifier = $defaults_output_identifier;
    }







}
