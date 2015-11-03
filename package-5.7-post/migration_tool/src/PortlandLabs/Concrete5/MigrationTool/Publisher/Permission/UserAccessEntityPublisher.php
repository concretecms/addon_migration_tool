<?php

namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Permission;


use Concrete\Core\Attribute\Key\CollectionKey;
use Concrete\Core\Permission\Access\Access;
use Concrete\Core\Permission\Key\Key;
use Concrete\Core\User\UserInfo;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\AttributeValue;
use Concrete\Core\Page\Page;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Permission\AccessEntity;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Permission\PublisherInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class UserAccessEntityPublisher extends AccessEntityPublisher
{

    protected function getAssignments(AccessEntity $entity)
    {
        $class = $this->getClass($entity);
        $ui = UserInfo::getByUserName($entity->getUserName());
        return $class::getOrCreate($ui);
    }

}
