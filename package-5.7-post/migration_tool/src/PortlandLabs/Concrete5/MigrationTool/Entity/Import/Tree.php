<?php

namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use PortlandLabs\Concrete5\MigrationTool\Publisher\PublishableInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Validator\ThumbnailTypeValidator;
use Gedmo\Mapping\Annotation as Gedmo;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Validator\TreeValidator;


/**
 * @Entity
 * @Table(name="MigrationImportTrees")
 */
class Tree implements PublishableInterface
{

    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ManyToOne(targetEntity="TreeObjectCollection")
     **/
    protected $collection;

    /**
     * @Column(type="string")
     */
    protected $type;

    /**
     * @Column(type="string")
     */
    protected $name;

    /**
     * @OneToMany(targetEntity="TreeNode", mappedBy="tree", cascade={"persist", "remove"})
     **/
    protected $nodes;

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
    public function getNodes()
    {
        return $this->nodes;
    }

    /**
     * @param mixed $nodes
     */
    public function setNodes($nodes)
    {
        $this->nodes = $nodes;
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
    public function getCollection()
    {
        return $this->collection;
    }

    public function __construct()
    {
        $this->nodes = new ArrayCollection();
    }

    /**
     * @param mixed $collection
     */
    public function setCollection($collection)
    {
        $this->collection = $collection;
    }



    public function getPublisherValidator()
    {
        return new TreeValidator($this);
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

    public function getRootNodes()
    {
        $criteria = Criteria::create()->where(Criteria::expr()->eq("parent", null));
        return $this->nodes->matching($criteria);
    }




}
