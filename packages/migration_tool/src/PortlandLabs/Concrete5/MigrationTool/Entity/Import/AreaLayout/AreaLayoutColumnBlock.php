<?php

namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\AreaLayout;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\MappedBlock;

/**
 * @Entity
 * @Table(name="MigrationImportAreaLayoutColumnBlocks")
 */
class AreaLayoutColumnBlock extends MappedBlock
{
    protected $area = null;

    /**
     * @ManyToOne(targetEntity="AreaLayoutColumn")
     **/
    protected $column;

    /**
     * @return mixed
     */
    public function getColumn()
    {
        return $this->column;
    }

    /**
     * @param mixed $column
     */
    public function setColumn($column)
    {
        $this->column = $column;
    }



}
