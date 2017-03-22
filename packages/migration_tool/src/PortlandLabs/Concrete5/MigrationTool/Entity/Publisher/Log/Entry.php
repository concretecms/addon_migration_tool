<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log;

use Doctrine\Common\Collections\ArrayCollection;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Attribute\ValidatableAttributesInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PublishableObject;
use PortlandLabs\Concrete5\MigrationTool\Publisher\PublishableInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Validator\PageValidator;
use Doctrine\ORM\Mapping as ORM;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Validator\SiteValidator;

/**
 * @ORM\Entity
 * @ORM\Table(name="MigrationPublisherLogEntries")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 */
abstract class Entry
{
    /**
     * @ORM\Id @ORM\Column(type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $timestamp;

    /**
     * @ORM\ManyToOne(targetEntity="Log", inversedBy="entries")
     **/
    protected $log;

    public function __construct(PublishableObject $object = null)
    {
        $this->timestamp = new \DateTime();
        $this->object = $object;
    }

    /**
     * @ORM\OneToOne(targetEntity="\PortlandLabs\Concrete5\MigrationTool\Entity\Import\PublishableObject", cascade={"persist","remove"})
     **/
    protected $object;

    /**
     * @return mixed
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * @param mixed $object
     */
    public function setObject($object)
    {
        $this->object = $object;
    }

    /**
     * @return mixed
     */
    public function getLog()
    {
        return $this->log;
    }

    /**
     * @param mixed $log
     */
    public function setLog($log)
    {
        $this->log = $log;
    }





}
