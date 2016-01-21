<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\AttributeKey\BlankFormatter;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Publisher\AttributeKey\StandardPublisher;
use PortlandLabs\Concrete5\MigrationTool\Publisher\PublishableInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Validator\AttributeKeyValidator;

/**
 * @Entity
 * @InheritanceType("JOINED")
 * @DiscriminatorColumn(name="type", type="string")
 * @Table(name="MigrationImportAttributeKeys")
 */
abstract class AttributeKey implements PublishableInterface
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ManyToOne(targetEntity="AttributeKeyObjectCollection")
     **/
    protected $collection;

    /**
     * @Column(type="string")
     */
    protected $handle;

    /**
     * @OneToOne(targetEntity="AttributeKeyCategoryInstance", inversedBy="key", cascade={"persist", "remove"})
     */
    protected $category;

    /**
     * @Column(type="string")
     */
    protected $name;

    /**
     * @Column(type="boolean")
     */
    protected $is_searchable = false;

    /**
     * @Column(type="boolean")
     */
    protected $is_internal = false;

    /**
     * @Column(type="boolean")
     */
    protected $is_indexed = false;

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

    /**
     * @return mixed
     */
    public function getIsInternal()
    {
        return $this->is_internal;
    }

    /**
     * @param mixed $is_internal
     */
    public function setIsInternal($is_internal)
    {
        $this->is_internal = $is_internal;
    }

    public function getPublisherValidator()
    {
        return new AttributeKeyValidator($this);
    }

    abstract public function getType();

    /**
     * @return AttributeKeyCategoryInstance
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
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
    public function getIsSearchable()
    {
        return $this->is_searchable;
    }

    /**
     * @param mixed $is_searchable
     */
    public function setIsSearchable($is_searchable)
    {
        $this->is_searchable = $is_searchable;
    }

    /**
     * @return mixed
     */
    public function getIsIndexed()
    {
        return $this->is_indexed;
    }

    /**
     * @param mixed $is_indexed
     */
    public function setIsIndexed($is_indexed)
    {
        $this->is_indexed = $is_indexed;
    }

    public function getFormatter()
    {
        return new BlankFormatter($this);
    }

    public function getRecordValidator(Batch $batch)
    {
        return false;
    }

    /**
     * @return \PortlandLabs\Concrete5\MigrationTool\Publisher\AttributeKey\PublisherInterface
     */
    public function getTypePublisher()
    {
        return new StandardPublisher();
    }
}
