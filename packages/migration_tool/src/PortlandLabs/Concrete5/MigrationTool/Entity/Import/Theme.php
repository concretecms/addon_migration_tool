<?php

namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;

use PortlandLabs\Concrete5\MigrationTool\Publisher\PublishableInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Validator\ThemeValidator;

/**
 * @Entity
 * @Table(name="MigrationImportPageThemes")
 */
class Theme implements PublishableInterface
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ManyToOne(targetEntity="ThemeObjectCollection")
     **/
    protected $collection;

    /**
     * @Column(type="string")
     */
    protected $handle;

    /**
     * @Column(type="boolean")
     */
    protected $is_activated = false;

    /**
     * @Column(type="string", nullable=true)
     */
    protected $package = null;

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
    public function getHandle()
    {
        return $this->handle;
    }

    /**
     * @param mixed $handle
     */
    public function setHandle($handle)
    {
        $this->handle = $handle;
    }

    /**
     * @return mixed
     */
    public function getPackage()
    {
        return $this->package;
    }

    /**
     * @param mixed $package
     */
    public function setPackage($package)
    {
        $this->package = $package;
    }

    public function getPublisherValidator()
    {
        return new ThemeValidator($this);
    }

    /**
     * @return mixed
     */
    public function getIsActivated()
    {
        return $this->is_activated;
    }

    /**
     * @param mixed $is_activated
     */
    public function setIsActivated($is_activated)
    {
        $this->is_activated = $is_activated;
    }
}
