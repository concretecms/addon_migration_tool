<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Page\Validator;

use Concrete\Core\Foundation\Processor\TargetInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Page;

defined('C5_EXECUTE') or die("Access Denied.");

class ValidatorTarget implements TargetInterface
{

    protected $page;
    protected $messages;

    public function __construct(Page $page)
    {
        $this->page = $page;
        $this->messages = new MessageCollection();
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