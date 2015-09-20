<?php

namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="MigrationImportBatches")
 */
class Batch
{

    /**
     * @Id @Column(type="guid")
     * @GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @Column(type="datetime")
     */
    protected $date;

    /**
     * @Column(type="text", nullable=true)
     */
    protected $notes;

    /**
     * @OneToMany(targetEntity="\PortlandLabs\Concrete5\MigrationTool\Entity\Import\Page", mappedBy="batch", cascade={"persist", "remove"})
     * @OrderBy({"position" = "ASC"})
     **/
    public $pages;

    /**
     * @OneToMany(targetEntity="\PortlandLabs\Concrete5\MigrationTool\Entity\Import\BatchTargetItem", mappedBy="batch", cascade={"persist", "remove"})
     **/
    public $target_items;


    public function __construct()
    {
        $this->date = new \DateTime();
        $this->pages = new ArrayCollection();
        $this->target_items = new ArrayCollection();
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
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * @param mixed $notes
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;
    }

    /**
     * @return mixed
     */
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * @param mixed $pages
     */
    public function setPages($pages)
    {
        $this->pages = $pages;
    }

    public function hasRecords()
    {
        return $this->pages->count() > 0;
    }

    public function getPagesOrderedForImport()
    {
        $pages = array();
        foreach($this->getPages() as $page) {
            $pages[] = $page;
        }
        usort($pages, function($pageA, $pageB) {
            $pathA = (string) $pageA->getBatchPath();
            $pathB = (string) $pageB->getBatchPath();
            $numA = count(explode('/', $pathA));
            $numB = count(explode('/', $pathB));
            if ($numA == $numB) {
                if (intval($pageA->getPosition()) < intval($pageB->getPosition())) {
                    return -1;
                } else {
                    if (intval($pageA->getPosition()) > intval($pageB->getPosition())) {
                        return 1;
                    } else {
                        return 0;
                    }
                }
            } else {
                return ($numA < $numB) ? -1 : 1;
            }
        });
        return $pages;
    }


}
