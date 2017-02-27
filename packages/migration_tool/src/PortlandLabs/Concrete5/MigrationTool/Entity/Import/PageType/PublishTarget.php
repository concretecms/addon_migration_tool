<?php

namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageType;

use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorInterface;

/**
 * @Entity
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="type", type="string")
 * @Table(name="MigrationImportPageTypePublishTargets")
 */
abstract class PublishTarget
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @OneToOne(targetEntity="PageType", mappedBy="publish_target")
     **/
    protected $type;

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

    abstract public function getFormatter();
    abstract public function getRecordValidator(ValidatorInterface $batch);
}
