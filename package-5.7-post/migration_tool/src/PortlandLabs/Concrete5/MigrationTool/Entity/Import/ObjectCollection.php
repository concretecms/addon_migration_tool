<?php

namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;

/**
 * @Entity
 * @Table(name="MigrationImportObjectCollections")
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="type", type="string")
 * @DiscriminatorMap( {
 * "page" = "PageObjectCollection",
 * "page_template" = "PageTemplateObjectCollection"
 * } )
 */
abstract class ObjectCollection
{

    /**
     * @Id @Column(type="guid")
     * @GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }




}
