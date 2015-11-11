<?php

namespace PortlandLabs\Concrete5\MigrationTool\Entity\Export;

use Concrete\Core\File\Set\Set;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity(repositoryClass="\PortlandLabs\Concrete5\MigrationTool\Entity\Export\BatchRepository")
 * @Table(name="MigrationExportBatches")
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
     * @JoinTable(name="MigrationExportBatchObjectCollections",
     *      joinColumns={@JoinColumn(name="batch_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="collection_id", referencedColumnName="id", unique=true)}
     *      )
     **/
    public $collections;

    public function __construct()
    {
        $this->date = new \DateTime();
        $this->collections = new ArrayCollection();
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
    public function getObjectCollections()
    {
        return $this->collections;
    }

    /**
     * @param mixed $collections
     */
    public function setObjectCollections($collections)
    {
        $this->collections = $collections;
    }


    public function hasRecords()
    {
        return $this->collections->count() > 0;
    }

    public function getObjectCollection($type)
    {
        foreach($this->collections as $collection) {
            if ($collection->getType() == $type) {
                return $collection;
            }
        }
    }

    /*
     * This used to work WITHOUT This but something about refactoring into ObjectCollections made this necessary in complex DQL queries.
     */
    public function __toString()
    {
        return $this->getID();
    }


}
