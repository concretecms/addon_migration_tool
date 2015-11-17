<?php

namespace PortlandLabs\Concrete5\MigrationTool\Publisher\AreaLayout;

use Concrete\Core\Attribute\Key\CollectionKey;
use Concrete\Core\Package\Package;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AreaLayout\AreaLayout;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\AttributeValue;
use Concrete\Core\Page\Page;

defined('C5_EXECUTE') or die("Access Denied.");

interface PublisherInterface
{

    /**
     * @param AreaLayout $layout
     */
    public function publish(AreaLayout $layout);


}
