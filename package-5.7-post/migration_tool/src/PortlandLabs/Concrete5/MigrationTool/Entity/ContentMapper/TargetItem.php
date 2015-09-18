<?php

namespace PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper;

use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\MapperInterface;

defined('C5_EXECUTE') or die("Access Denied.");

/**
 * @Entity
 * @Table(name="MigrationContentMapperTargetItems")
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="entity_type", type="string")
 * @DiscriminatorMap( {"target_item" = "TargetItem", "unmapped" = "UnmappedTargetItem", "ignored"="IgnoredTargetItem"} )
 */
class TargetItem implements TargetItemInterface
{

    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     * @Column(type="string")
     */
    protected $source_item_identifier;

    /**
     * @Column(type="integer")
     */
    protected $item_id;

    /**
     * @Column(type="string")
     */
    protected $item_type;

    protected $item_name;

    public function __construct(MapperInterface $mapper)
    {
        $this->item_type = $mapper->getHandle();
    }

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
    public function getItemId()
    {
        return $this->item_id;
    }

    /**
     * @param mixed $item_id
     */
    public function setItemId($item_id)
    {
        $this->item_id = $item_id;
    }

    /**
     * @return mixed
     */
    public function getItemType()
    {
        return $this->item_type;
    }

    /**
     * @param mixed $item_type
     */
    public function setItemType($item_type)
    {
        $this->item_type = $item_type;
    }

    /**
     * @return mixed
     */
    public function getItemName()
    {
        return $this->item_name;
    }

    /**
     * @param mixed $item_name
     */
    public function setItemName($item_name)
    {
        $this->item_name = $item_name;
    }

    /**
     * @return mixed
     */
    public function getSourceItemIdentifier()
    {
        return $this->source_item_identifier;
    }

    /**
     * @param mixed $source_item_identifier
     */
    public function setSourceItemIdentifier($source_item_identifier)
    {
        $this->source_item_identifier = $source_item_identifier;
    }




}
