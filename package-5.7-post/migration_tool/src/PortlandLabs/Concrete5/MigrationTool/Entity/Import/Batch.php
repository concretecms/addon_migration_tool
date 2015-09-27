<?php

namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;

use Concrete\Core\File\Set\Set;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity(repositoryClass="\PortlandLabs\Concrete5\MigrationTool\Entity\Import\BatchRepository")
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
     * @ManyToMany(targetEntity="ObjectCollection", cascade={"persist", "remove"}))
     * @JoinTable(name="MigrationImportBatchObjectCollections",
     *      joinColumns={@JoinColumn(name="batch_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="collection_id", referencedColumnName="id", unique=true)}
     *      )
     **/
    public $collections;

    /**
     * @OneToMany(targetEntity="\PortlandLabs\Concrete5\MigrationTool\Entity\Import\BatchTargetItem", mappedBy="batch", cascade={"persist", "remove"})
     **/
    public $target_items;


    public function __construct()
    {
        $this->date = new \DateTime();
        $this->collections = new ArrayCollection();
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
    public function getCollections()
    {
        return $this->collections;
    }

    /**
     * @param mixed $collections
     */
    public function setCollections($collections)
    {
        $this->collections = $collections;
    }


    public function hasRecords()
    {
        return $this->collections->count() > 0;
    }

    /**
     * Returns all pages from all page collection objects in the batch.
     */
    public function getPages()
    {
        $pages = array();
        foreach($this->getCollections() as $collection) {
            if ($collection instanceof PageObjectCollection) {
                $pages = array_merge($pages, $collection->getPages()->toArray());
            }
        }
        return $pages;
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

    /**
     * @return mixed
     */
    public function getTargetItems()
    {
        return $this->target_items;
    }

    /**
     * @param mixed $target_items
     */
    public function setTargetItems($target_items)
    {
        $this->target_items = $target_items;
    }

    public function getFileSet()
    {
        $fs = Set::getByName($this->getID());
        return $fs;
    }
    public function getFiles()
    {
        $fs = $this->getFileSet();
        if (is_object($fs)) {
            $files = $fs->getFiles();
            return $files;
        }
        return array();
    }

    /*
     * This used to work WITHOUT This but something about refactoring into ObjectCollections made this necessary in complex DQL queries.
     */
    public function __toString()
    {
        return $this->getID();
    }


}
