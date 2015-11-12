<?php

namespace PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\Type;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Area;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Attribute;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BannedWordObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Block;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\CaptchaObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Conversation\FlagType;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Conversation\FlagTypeObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageAttribute;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageTemplate as CorePageTemplate;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageTemplateObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\SocialLinkObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Workflow\Type;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Workflow\TypeObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\TypeInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class Captcha implements TypeInterface
{

    public function getObjectCollection(\SimpleXMLElement $element)
    {
        $collection = new CaptchaObjectCollection();
        if ($element->systemcaptcha->library) {
            foreach($element->systemcaptcha->library as $node) {
                $library = new \PortlandLabs\Concrete5\MigrationTool\Entity\Import\Captcha();
                $library->setHandle((string) $node['handle']);
                $library->setName((string) $node['name']);
                $library->setPackage((string) $node['package']);
                $library->setIsActivated((string) $node['activated']);

                $collection->getLibraries()->add($library);
                $library->setCollection($collection);
            }
        }
        return $collection;
    }

}
