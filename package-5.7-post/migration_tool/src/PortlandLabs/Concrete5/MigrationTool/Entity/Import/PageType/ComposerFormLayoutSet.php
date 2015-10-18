<?php

namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageType;

use Doctrine\Common\Collections\ArrayCollection;


/**
 * @Entity
 * @Table(name="MigrationImportPageTypeComposerFormLayoutSets")
 */
class ComposerFormLayoutSet
{

    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @OneToMany(targetEntity="ComposerFormLayoutSetControl", mappedBy="set", cascade={"persist", "remove"})
     * @OrderBy({"position" = "ASC"})
     **/
    public $controls;

    /**
     * @ManyToOne(targetEntity="PageType")
     **/
    protected $type;

    /**
     * @Column(type="integer")
     */
    protected $position = 0;

    /**
     * @Column(type="string")
     */
    protected $name;

    /**
     * @Column(type="string", nullable=true)
     */
    protected $description;

    /**
     * @return mixed
     */

    public function __construct()
    {
        $this->controls = new ArrayCollection();
    }

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
    public function getControls()
    {
        return $this->controls;
    }

    /**
     * @param mixed $controls
     */
    public function setControls($controls)
    {
        $this->controls = $controls;
    }

    /**
     * @return mixed
     */
    public function getPageType()
    {
        return $this->page_type;
    }

    /**
     * @param mixed $page_type
     */
    public function setPageType($page_type)
    {
        $this->page_type = $page_type;
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
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
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






}
