<?php

namespace PortlandLabs\Concrete5\MigrationTool\Inspector\Block;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue;

defined('C5_EXECUTE') or die("Access Denied.");

interface InspectorInterface
{

    public function getMatchedItems();


}
