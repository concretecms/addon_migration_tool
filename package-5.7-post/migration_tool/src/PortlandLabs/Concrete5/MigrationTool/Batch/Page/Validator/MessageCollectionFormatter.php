<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Page\Validator;

defined('C5_EXECUTE') or die("Access Denied.");

class MessageCollectionFormatter extends MessageFormatter
{

    protected $collection;

    public function __construct(MessageCollection $collection)
    {
        $this->collection = $collection;
    }

    protected function getSeverity()
    {
        $severity = false;
        if ($this->collection->count() > 0) {
            $severity = Message::E_INFO;
            foreach($this->collection as $message) {
                if ($message->getSeverity() == Message::E_DANGER) {
                    $severity = Message::E_DANGER;
                    break;
                }

                if ($message->getSeverity() == Message::E_WARNING) {
                    $severity = Message::E_WARNING;
                }
            }
        }
        return $severity;
    }

    public function outputCollectionStatusIcon()
    {
        if ($this->collection->count() > 0) {
            return sprintf('<i class="%s %s"></i>',
                $this->getTextClass(),
                $this->getIconClass()
            );
        } else {
            return '';
        }
    }

}