<?php

namespace PortlandLabs\Concrete5\MigrationTool\Publisher\AttributeKeyCategory;

use Concrete\Core\Attribute\Key\CollectionKey;
use Concrete\Core\Package\Package;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\AttributeValue;
use Concrete\Core\Page\Page;

defined('C5_EXECUTE') or die("Access Denied.");

interface PublisherInterface
{

    /**
     * @param AttributeKey $ak
     * @return \Concrete\Core\Attribute\Key\Key
     */
    public function publish(AttributeKey $ak, Package $pkg = null);


}
