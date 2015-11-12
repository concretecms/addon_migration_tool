<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Block;

use Concrete\Core\Foundation\Processor\TargetInterface;
use Doctrine\Common\Collections\ArrayCollection;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Message;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\MessageCollection;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorTargetInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

class CollectionValidatorTarget implements ValidatorTargetInterface
{

    protected $blocks;
    protected $messages;
    protected $batch;

    public function __construct(Batch $batch, $blocks)
    {
        $this->blocks = $blocks;
        $this->batch = $batch;
        $this->messages = new MessageCollection();
    }

    /**
     * @return Batch
     */
    public function getBatch()
    {
        return $this->batch;
    }

    /**
     * @param Batch $batch
     */
    public function setBatch($batch)
    {
        $this->batch = $batch;
    }

    public function getItems()
    {
        return array($this->blocks);
    }

    public function addMessage(Message $message)
    {
        $this->messages->add($message);
    }

    public function getMessages()
    {
        return $this->messages;
    }

}