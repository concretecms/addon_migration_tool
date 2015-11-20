<?php

namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageType\ComposerControlType;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageType\ComposerControlTypeObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\ElementInterface;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\ElementParserInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class PageTypeComposerControlType implements ElementParserInterface
{

    public function getObjectCollection(\SimpleXMLElement $element)
    {
        $collection = new ComposerControlTypeObjectCollection();
        if ($element->pagetypecomposercontroltypes->type) {
            foreach($element->pagetypecomposercontroltypes->type as $node) {
                $type = new ComposerControlType();
                $type->setHandle((string) $node['handle']);
                $type->setName((string) $node['name']);
                $type->setPackage((string) $node['package']);
                $collection->getTypes()->add($type);
                $type->setCollection($collection);
            }
        }
        return $collection;
    }

}
