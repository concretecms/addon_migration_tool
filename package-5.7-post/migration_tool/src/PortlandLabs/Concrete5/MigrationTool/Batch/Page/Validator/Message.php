<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Page\Validator;

use Concrete\Core\Foundation\Processor\Processor;
use Concrete\Core\Foundation\Processor\TaskInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Page;

defined('C5_EXECUTE') or die("Access Denied.");

class Message
{

    const E_INFO = 1;
    const E_WARNING = 5;
    const E_DANGER = 10;

    protected $severity;
    protected $text;

    public function __construct($text, $severity = self::E_DANGER)
    {
        $this->severity = $severity;
        $this->text = $text;
    }

    /**
     * @return mixed
     */
    public function getSeverity()
    {
        return $this->severity;
    }

    /**
     * @param mixed $severity
     */
    public function setSeverity($severity)
    {
        $this->severity = $severity;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    public function getFormatter()
    {
        return new MessageFormatter($this);
    }

}