<?php

namespace PortlandLabs\Concrete5\MigrationTool\Publisher\AreaLayout;

use Concrete\Core\Attribute\Key\CollectionKey;
use Concrete\Core\Package\Package;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AreaLayout\AreaLayout;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\AttributeValue;
use Concrete\Core\Page\Page;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AreaLayout\CustomAreaLayout;
use Concrete\Core\Area\Layout\ThemeGridLayout;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AreaLayout\ThemeGridAreaLayoutColumn;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AreaLayout\ThemeGridAreaLayout;

defined('C5_EXECUTE') or die("Access Denied.");

class ThemeGridAreaLayoutPublisher implements PublisherInterface
{

    /**
     * @param ThemeGridAreaLayout $layout
     */
    public function publish(AreaLayout $layout)
    {
        $arLayout = ThemeGridLayout::add();
        foreach($layout->getColumns() as $column) {
            /**
             * @var $column ThemeGridAreaLayoutColumn
             */
            $columnObject = $arLayout->addLayoutColumn();
            $columnObject->setAreaLayoutColumnSpan($column->getSpan());
            $columnObject->setAreaLayoutColumnOffset($column->getOffset());
        }
        return $arLayout;
    }


}
