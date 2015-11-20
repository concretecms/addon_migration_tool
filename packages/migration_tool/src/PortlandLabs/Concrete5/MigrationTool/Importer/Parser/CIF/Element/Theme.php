<?php

namespace PortlandLabs\Concrete5\MigrationTool\Importer\Parser\CIF\Element;

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
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\ThemeObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Workflow\Type;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Workflow\TypeObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Importer\ContentType\TypeInterface;
use PortlandLabs\Concrete5\MigrationTool\Importer\Parser\CIF\ElementParserInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class Theme implements ElementParserInterface
{

    public function getObjectCollection(\SimpleXMLElement $element)
    {
        $collection = new ThemeObjectCollection();
        if ($element->themes->theme) {
            foreach($element->themes->theme as $node) {
                $theme = new \PortlandLabs\Concrete5\MigrationTool\Entity\Import\Theme();
                $theme->setHandle((string) $node['handle']);
                $theme->setPackage((string) $node['package']);
                $theme->setIsActivated((string) $node['activated']);
                $collection->getThemes()->add($theme);
                $theme->setCollection($collection);
            }
        }
        return $collection;
    }

}
