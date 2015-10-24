<?php

namespace PortlandLabs\Concrete5\MigrationTool\Publisher\AttributeKeyCategory;


use Concrete\Core\Attribute\Key\UserKey;
use Concrete\Core\Package\Package;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\UserAttributeKeyCategoryInstance;

defined('C5_EXECUTE') or die("Access Denied.");

class UserPublisher implements PublisherInterface
{

    public function publish(AttributeKey $ak, Package $pkg = null)
    {
        /** @var $category UserAttributeKeyCategoryInstance */
        $category = $ak->getCategory();

        $key = UserKey::add($ak->getType(),
            array(
                'akHandle' => $ak->getHandle(),
                'akName' => $ak->getName(),
                'akIsInternal' => $ak->getIsInternal(),
                'akIsSearchableIndexed' => $ak->getIsIndexed(),
                'akIsSearchable' => $ak->getIsSearchable(),
                'uakProfileDisplay' => $category->getDisplayedInProfile(),
                'uakProfileEdit' => $category->getEditableInProfile(),
                'uakProfileEditRequired' => $category->getRequiredInProfile(),
                'uakRegisterEdit' => $category->getEditableInRegistration(),
                'uakRegisterEditRequired' => $category->getRequiredInRegistration(),
                'uakMemberListDisplay' => $category->getDisplayedInMemberList()
            ), $pkg);
        return $key;

    }

}
