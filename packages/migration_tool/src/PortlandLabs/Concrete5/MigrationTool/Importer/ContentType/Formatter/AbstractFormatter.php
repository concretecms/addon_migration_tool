<?php

namespace PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Formatter;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\ObjectCollection;

defined('C5_EXECUTE') or die("Access Denied.");

abstract class AbstractFormatter implements FormatterInterface
{

    protected $collection;

    public function __construct(ObjectCollection $collection)
    {
        $this->collection = $collection;
    }

    public function getElement()
    {
        return $this->collection->getType();
    }

    public function displayObjectCollection()
    {
        $em = \ORM::entityManager('migration_tool');
        $r = $em->getRepository("\PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch");
        $batch = $r->findFromCollection($this->collection);
        print \View::element('batch_content_types/'
            . $this->getElement(), array(
            'batch' => $batch,
            'type' => $this->collection->getType(),
            'collection' => $this->collection
        ), 'migration_tool');
    }

}
