<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\Conversation;

use Doctrine\Common\Collections\ArrayCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\ObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\ObjectCollection\ConversationEditorFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorInterface;

/**
 * @Entity
 */
class EditorObjectCollection extends ObjectCollection
{
    /**
     * @OneToMany(targetEntity="\PortlandLabs\Concrete5\MigrationTool\Entity\Import\Conversation\Editor", mappedBy="collection", cascade={"persist", "remove"})
     **/
    public $editors;

    public function __construct()
    {
        $this->editors = new ArrayCollection();
    }

    public function getFormatter()
    {
        return new ConversationEditorFormatter($this);
    }

    /**
     * @return mixed
     */
    public function getEditors()
    {
        return $this->editors;
    }

    /**
     * @param mixed $editors
     */
    public function setEditors($editors)
    {
        $this->editors = $editors;
    }

    public function getType()
    {
        return 'conversation_editor';
    }

    public function hasRecords()
    {
        return count($this->getEditors());
    }

    public function getRecords()
    {
        return $this->getEditors();
    }

    public function getTreeFormatter()
    {
        return false;
    }

    public function getRecordValidator(ValidatorInterface $batch)
    {
        return false;
    }
}
