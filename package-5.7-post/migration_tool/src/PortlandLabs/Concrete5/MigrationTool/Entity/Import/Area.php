<?php

namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="MigrationImportAreas")
 */
class Area
{

    /**
     * @Id @Column(type="guid")
     * @GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @OneToMany(targetEntity="\PortlandLabs\Concrete5\MigrationTool\Entity\Import\Block", mappedBy="area", cascade={"persist", "remove"})
     * @OrderBy({"position" = "ASC"})
     **/
    public $blocks;

    /**
     * @ManyToOne(targetEntity="Page")
     **/
    protected $page;


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
     * @return mixed
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param mixed $page
     */
    public function setPage($page)
    {
        $this->page = $page;
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


    public function __construct()
    {
        $this->blocks = new ArrayCollection();
    }


}
