<?php

namespace PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Type;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Area;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Attribute;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Block;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockTypeObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\JobObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PackageObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageAttribute;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockType as CoreBlockType;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageTemplateObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\TypeInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class Package implements TypeInterface
{

    public function getObjectCollection(\SimpleXMLElement $element)
    {
        $collection = new PackageObjectCollection();
        if ($element->packages->package) {
            foreach($element->packages->package as $node) {
                $pkg = new \PortlandLabs\Concrete5\MigrationTool\Entity\Import\Package();
                $pkg->setHandle((string) $node['handle']);
                $collection->getPackages()->add($pkg);
                $pkg->setCollection($collection);
            }
        }
        return $collection;
    }

}
