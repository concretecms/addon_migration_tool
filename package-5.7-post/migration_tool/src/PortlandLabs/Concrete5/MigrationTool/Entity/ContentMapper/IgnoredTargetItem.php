<?php

namespace PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper;

use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\MapperInterface;

defined('C5_EXECUTE') or die("Access Denied.");

/**
 * @Entity
 */
class IgnoredTargetItem extends TargetItem
{

    public function __construct(MapperInterface $mapper)
    {
        parent::__construct($mapper);
        $this->setItemId(-1);
        $this->setItemName(t('Ignored'));
    }

}
