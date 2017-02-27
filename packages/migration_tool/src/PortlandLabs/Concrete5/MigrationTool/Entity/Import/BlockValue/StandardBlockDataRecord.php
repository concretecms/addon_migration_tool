<?php

namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue;

/**
 * @Entity
 * @Table(name="MigrationImportBlockValueDataRecords")
 */
class StandardBlockDataRecord
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Column(type="json_array")
     */
    protected $data;

    /**
     * @Column(type="string", nullable=true)
     */
    protected $record_table;

    /**
     * @ManyToOne(targetEntity="StandardBlockValue")
     **/
    protected $value;

    /**
     * @Column(type="integer")
     */
    protected $position;

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
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getTable()
    {
        return $this->record_table;
    }

    /**
     * @param mixed $table
     */
    public function setTable($record_table)
    {
        $this->record_table = $record_table;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param mixed $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }
}
