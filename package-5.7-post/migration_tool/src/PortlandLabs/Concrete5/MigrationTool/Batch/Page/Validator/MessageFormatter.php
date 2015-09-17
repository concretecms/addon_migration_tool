<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Page\Validator;

defined('C5_EXECUTE') or die("Access Denied.");

class MessageFormatter
{

    protected $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    protected function getSeverity()
    {
        return $this->message->getSeverity();
    }

    protected function getTextClass()
    {
        switch($this->getSeverity()) {
            case Message::E_DANGER:
                return 'text-danger';
                break;
            case Message::E_WARNING:
                return 'text-warning';
                break;
            default:
                return 'text-info';
                break;
        }
    }

    protected function getIconClass()
    {
        switch($this->getSeverity()) {
            case Message::E_DANGER:
                return 'fa fa-exclamation-triangle';
                break;
            case Message::E_WARNING:
                return 'fa fa-exclamation';
                break;
            default:
                return 'fa fa-info-circle';
                break;
        }
    }

    public function output()
    {
        return sprintf('<span class="%s"><i class="%s"></i> %s</span>',
            $this->getTextClass(),
            $this->getIconClass(),
            $this->message->getText()
        );
    }

}