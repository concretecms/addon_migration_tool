<?php

namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\Permission;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\PermissionKey\AccessEntityFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\PermissionKey\AccessEntityValidator;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Permission\AccessEntityPublisher;
use PortlandLabs\Concrete5\MigrationTool\Publisher\PublishableInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Validator\PermissionAccessEntityTypeValidator;

/**
 * @Entity
 * @InheritanceType("JOINED")
 * @DiscriminatorColumn(name="type", type="string")
 * @Table(name="MigrationImportPermissionAccessEntities")
 */
class AccessEntity
{

    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ManyToOne(targetEntity="Key")
     **/
    protected $key;

    /**
     * @Column(type="string")
     */
    protected $entity_type;

    /**
     * @return mixed
     */
    public function getEntityType()
    {
        return $this->entity_type;
    }

    /**
     * @param mixed $entity_type
     */
    public function setEntityType($entity_type)
    {
        $this->entity_type = $entity_type;
    }

    /**
     * @return mixed
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param mixed $key
     */
    public function setKey($key)
    {
        $this->key = $key;
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


    public function getFormatter()
    {
        return new AccessEntityFormatter($this);
    }

    public function getRecordValidator(Batch $batch)
    {
        return new AccessEntityValidator($batch);
    }

    public function getPublisher()
    {
        return new AccessEntityPublisher();
    }


}
