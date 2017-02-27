<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\Conversation;

use PortlandLabs\Concrete5\MigrationTool\Publisher\PublishableInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Validator\ConversationRatingTypeValidator;

/**
 * @Entity
 * @Table(name="MigrationImportConversationRatingTypes")
 */
class RatingType implements PublishableInterface
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ManyToOne(targetEntity="\PortlandLabs\Concrete5\MigrationTool\Entity\Import\Conversation\RatingTypeObjectCollection")
     **/
    protected $collection;

    /**
     * @Column(type="string")
     */
    protected $handle;

    /**
     * @Column(type="string")
     */
    protected $name;

    /**
     * @Column(type="integer")
     */
    protected $points;

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
        return new ConversationRatingTypeValidator($this);
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * @param mixed $points
     */
    public function setPoints($points)
    {
        $this->points = $points;
    }
}
