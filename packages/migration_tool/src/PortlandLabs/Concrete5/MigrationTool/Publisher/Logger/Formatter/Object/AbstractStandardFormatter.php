<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\Formatter\Object;

use HtmlObject\Element;
use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Entry;
use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Object\LoggableObject;
use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\PublishedEntry;
use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\SkippedEntry;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\Formatter\FormatterInterface;

defined('C5_EXECUTE') or die("Access Denied.");

abstract class AbstractStandardFormatter implements FormatterInterface
{

    abstract public function getSkippedDescription(LoggableObject $object);
    abstract public function getPublishedDescription(LoggableObject $object);

    public function getEntryStatusElement(Entry $object)
    {
        $div = new Element('div', '', ['class' => $this->getTextClass($object)]);
        if ($object instanceof SkippedEntry) {
            $div->appendChild(new Element('span', t('Skipped')));
            $div->appendChild(new Element('span', ' '));
            $div->appendChild(new Element('i', '', ['class' => 'fa fa-share']));
        } else if ($object instanceof PublishedEntry) {
            $div->appendChild(new Element('span', t('Published')));
            $div->appendChild(new Element('span', ' '));
            $div->appendChild(new Element('i', '', ['class' => 'fa fa-thumbs-up']));
        }
        return $div;
    }

    protected function getTextClass(Entry $entry)
    {
        $textClass = '';
        if ($entry instanceof SkippedEntry) {
            $textClass = 'text-muted';
        } else if ($entry instanceof PublishedEntry) {
            $textClass = 'text-success';
        }
        return $textClass;
    }

    public function getDescriptionElement(Entry $entry)
    {
        $object = $entry->getObject();
        $textClass = $this->getTextClass($entry);
        $description = '';
        if ($entry instanceof SkippedEntry) {
            $description = $this->getSkippedDescription($object);
        } else if ($entry instanceof PublishedEntry) {
            $description = $this->getPublishedDescription($object);
        }
        $div = new Element('div', $description, ['class' => $textClass]);
        return $div;
    }

}
