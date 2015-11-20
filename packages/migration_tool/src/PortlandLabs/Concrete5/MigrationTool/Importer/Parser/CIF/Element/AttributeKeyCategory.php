<?php

namespace PortlandLabs\Concrete5\MigrationTool\Importer\Parser\CIF\Element;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Area;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Attribute;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKeyCategoryObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Block;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Conversation\Editor;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Conversation\EditorObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageAttribute;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageTemplate as CorePageTemplate;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageTemplateObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Importer\Parser\CIF\ElementParserInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class AttributeKeyCategory implements ElementParserInterface
{

    public function getObjectCollection(\SimpleXMLElement $element)
    {
        $this->simplexml = $element;
        $collection = new AttributeKeyCategoryObjectCollection();
        if ($element->attributecategories->category) {
            foreach($element->attributecategories->category as $node) {
                $category = new \PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKeyCategory();
                $category->setHandle((string) $node['handle']);
                $category->setAllowSets((string) $node['allow-sets']);
                $category->setPackage((string) $node['package']);
                $collection->getCategories()->add($category);
                $category->setCollection($collection);
            }
        }
        return $collection;
    }

}
