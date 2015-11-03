<?php

namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;

use PortlandLabs\Concrete5\MigrationTool\Publisher\PublishableInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Validator\ConfigValueValidator;


/**
 * @Entity
 * @Table(name="MigrationImportConfigValues")
 */
class ConfigValue implements PublishableInterface
{

    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ManyToOne(targetEntity="ConfigValueObjectCollection")
     **/
    protected $collection;

    /**
     * @Column(type="string")
     */
    protected $config_key;

    /**
     * @Column(type="text")
     */
    protected $config_value;

    /**
     * @Column(type="string", nullable=true)
     */
    protected $package = null;


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
        return new ConfigValueValidator($this);
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
    public function getConfigKey()
    {
        return $this->config_key;
    }

    /**
     * @param mixed $key
     */
    public function setConfigKey($key)
    {
        $this->config_key = $key;
    }

    /**
     * @return mixed
     */
    public function getConfigValue()
    {
        return $this->config_value;
    }

    /**
     * @param mixed $value
     */
    public function setConfigValue($value)
    {
        $this->config_value = $value;
    }


}
