<?php

namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;

use Doctrine\Common\Collections\ArrayCollection;
use PortlandLabs\Concrete5\MigrationTool\Publisher\PublishableInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Validator\StackValidator;


/**
 * @Entity
 * @Table(name="MigrationImportStacks")
 */
class Stack implements PublishableInterface
{

    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        $this->blocks = new ArrayCollection();
    }

    /**
     * @ManyToOne(targetEntity="StackObjectCollection")
     **/
    protected $collection;

    /**
     * @ManyToMany(targetEntity="StackBlock", cascade={"persist", "remove"})
     */
    protected $blocks;

    /**
     * @Column(type="string")
     */
    protected $type;

    /**
     * @Column(type="string")
     */
    protected $name;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getCollection()
    {
        return $this->collection;
    }

    /**
     * @param mixed $collection
     */
    public function setCollection($collection)
    {
        $this->collection = $collection;
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
    public function getBlocks()
    {
        return $this->blocks;
    }

    /**
     * @param mixed $blocks
     */
    public function setBlocks($blocks)
    {
        $this->blocks = $blocks;
    }

    public function getPublisherValidator()
    {
        return new StackValidator($this);
    }



}
