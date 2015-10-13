<?php

namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Permission;


use Concrete\Core\Attribute\Key\CollectionKey;
use Concrete\Core\Permission\Access\Access;
use Concrete\Core\Permission\Key\Key;
use Concrete\Core\User\Group\Group;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue;
use Concrete\Core\Page\Page;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Permission\AccessEntity;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Permission\PublisherInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class GroupAccessEntityPublisher extends AccessEntityPublisher
{

    protected function getAssignments(AccessEntity $entity)
    {
        $class = $this->getClass($entity);
        $g = Group::getByName($entity->getGroupName());
        return $class::getOrCreate($g);
    }

}
