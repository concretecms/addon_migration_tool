<?php
namespace PortlandLabs\Concrete5\MigrationTool\Exporter;

use PortlandLabs\Concrete5\MigrationTool\Entity\Export\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

class Exporter
{
    protected $batch;
    protected $built = false;
    protected $element;

    public function __construct(Batch $batch)
    {
        $this->batch = $batch;
    }

    protected function build()
    {
        $this->element = new \SimpleXMLElement("<?xml version=\"1.0\" encoding=\"UTF-8\"?><concrete5-cif></concrete5-cif>");
        $this->element->addAttribute('version', '1.0');
        foreach ($this->batch->getObjectCollections() as $collection) {
            $type = $collection->getItemTypeObject();
            $type->exportCollection($collection, $this->element);
        }
    }

    public function getElement()
    {
        if (!$this->built) {
            $this->build();
        }

        return $this->element;
    }
}
