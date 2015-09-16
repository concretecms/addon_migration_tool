<?php

namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;
/**
 * @Entity
 * @Table(name="MigrationImportAttributes")
 */
class Attribute
{

    /**
     * @Id @Column(type="guid")
     * @GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @Column(type="string")
     */
    protected $handle;

    /**
     * @Column(type="text")
     */
    protected $value_xml;

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
    public function getValueXml()
    {
        return $this->value_xml;
    }

    /**
     * @param mixed $value_xml
     */
    public function setValueXml($value_xml)
    {
        $this->value_xml = $value_xml;
    }


}
