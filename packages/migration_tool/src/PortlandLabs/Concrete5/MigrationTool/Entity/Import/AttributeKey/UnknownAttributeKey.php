<?php

namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey;


/**
 * @Entity
 * @Table(name="MigrationImportUnknownKeys")
 */
class UnknownAttributeKey extends AttributeKey
{

    /**
     * @Column(type="text")
     */
    protected $options_xml = false;

    /**
     * @return mixed
     */
    public function getOptionsXml()
    {
        return $this->options_xml;
    }

    /**
     * @param mixed $options_xml
     */
    public function setOptionsXml($options_xml)
    {
        $this->options_xml = $options_xml;
    }


    public function getType()
    {
        return 'unknown';
    }

}
