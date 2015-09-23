<?php

namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;

/**
 * @Entity
 * @Table(name="MigrationImportAttributeValues")
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="value_type", type="string")
 * @DiscriminatorMap( {"standard" = "StandardAttributeValue", "imported" = "ImportedAttributeValue"} )
 */
abstract class AttributeValue
{

    /**
     * @Id @Column(type="guid")
     * @GeneratedValue(strategy="UUID")
     */
    protected $id;


    /**
     * @OneToOne(targetEntity="\PortlandLabs\Concrete5\MigrationTool\Entity\Import\Attribute", mappedBy="attribute_value")
     **/
    protected $attribute;

    /**
     * @Column(type="text")
     */
    protected $value;

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
    public function getAttribute()
    {
        return $this->attribute;
    }

    /**
     * @param mixed $attribute
     */
    public function setAttribute($attribute)
    {
        $this->attribute = $attribute;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }


    abstract public function getFormatter();
    abstract public function getValue();
    abstract public function setValue($value);
    abstract public function getPublisher();

}
