<?php

namespace PortlandLabs\Concrete5\MigrationTool\Importer\Parser\CIF\Element;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Area;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Attribute;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Block;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Conversation\FlagType;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Conversation\FlagTypeObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageAttribute;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageTemplate as CorePageTemplate;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageTemplateObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Workflow\ProgressCategory;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Workflow\ProgressCategoryObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Workflow\Type;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Workflow\TypeObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\TypeInterface;
use PortlandLabs\Concrete5\MigrationTool\Importer\Parser\CIF\ElementParserInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class WorkflowProgressCategory implements ElementParserInterface
{

    public function getObjectCollection(\SimpleXMLElement $element)
    {
        $collection = new ProgressCategoryObjectCollection();
        if ($element->workflowprogresscategories->category) {
            foreach($element->workflowprogresscategories->category as $node) {
                $category = new ProgressCategory();
                $category->setHandle((string) $node['handle']);
                $category->setPackage((string) $node['package']);
                $collection->getCategories()->add($category);
                $category->setCollection($collection);
            }
        }
        return $collection;
    }

}
