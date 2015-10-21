<?php

namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\AttributeKey\TextAreaFormatter;


/**
 * @Entity
 * @Table(name="MigrationImportTextAreaAttributeKeys")
 */
class TextAreaAttributeKey extends AttributeKey
{

    /**
     * @Column(type="string")
     */
    protected $mode = '';

    /**
     * @return mixed
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * @param mixed $mode
     */
    public function setMode($mode)
    {
        $this->mode = $mode;
    }


    public function getType()
    {
        return 'text_area';
    }

    public function getFormatter()
    {
        return new TextAreaFormatter($this);
    }

}
