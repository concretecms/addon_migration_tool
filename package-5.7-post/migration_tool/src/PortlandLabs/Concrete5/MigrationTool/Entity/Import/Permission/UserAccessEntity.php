<?php

namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\Permission;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\PermissionKey\UserAccessEntityFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\PermissionKey\UserAccessEntityValidator;
use PortlandLabs\Concrete5\MigrationTool\Publisher\PublishableInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Validator\PermissionAccessEntityTypeValidator;

/**
 * @Entity
 * @Table(name="MigrationImportUserPermissionAccessEntities")
 */
class UserAccessEntity extends AccessEntity
{

    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Column(type="string")
     */
    protected $user_name;

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
    public function getUserName()
    {
        return $this->user_name;
    }

    /**
     * @param mixed $user_name
     */
    public function setUserName($user_name)
    {
        $this->user_name = $user_name;
    }

    public function getFormatter()
    {
        return new UserAccessEntityFormatter($this);
    }

    public function getRecordValidator()
    {
        return new UserAccessEntityValidator();
    }

    public function getPublisher()
    {
        return new CIFPublisher();
    }





}
