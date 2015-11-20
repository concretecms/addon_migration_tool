<?php

namespace PortlandLabs\Concrete5\MigrationTool\Importer\Parser\CIF\Element;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Area;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Attribute;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Block;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockTypeObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\JobObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageAttribute;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockType as CoreBlockType;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageTemplateObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\TypeInterface;
use PortlandLabs\Concrete5\MigrationTool\Importer\Parser\CIF\ElementParserInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class Job implements ElementParserInterface
{

    public function getObjectCollection(\SimpleXMLElement $element)
    {
        $collection = new JobObjectCollection();
        if ($element->jobs->job) {
            foreach($element->jobs->job as $node) {
                $job = new \PortlandLabs\Concrete5\MigrationTool\Entity\Import\Job();
                $job->setHandle((string) $node['handle']);
                $job->setPackage((string) $node['package']);
                $collection->getJobs()->add($job);
                $job->setCollection($collection);
            }
        }
        return $collection;
    }

}
