<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Page\Validator;

use Concrete\Core\Foundation\Processor\TargetInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Page;

defined('C5_EXECUTE') or die("Access Denied.");

class ValidatorTarget implements TargetInterface
{

    protected $page;
    protected $messages;
    protected $batch;

    public function __construct(Batch $batch, Page $page)
    {
        $this->page = $page;
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
        return array($this->page);
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