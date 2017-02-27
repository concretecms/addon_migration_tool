<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\AttributeKeyCategory;

use Concrete\Core\Attribute\Key\Category;
use Concrete\Core\Attribute\Key\UserKey;
use Concrete\Core\Package\Package;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\UserAttributeKeyCategoryInstance;

defined('C5_EXECUTE') or die("Access Denied.");

class UserPublisher implements PublisherInterface
{
    public function publish(AttributeKey $ak, Package $pkg = null)
    {
        /** @var $category UserAttributeKeyCategoryInstance */
        $category = $ak->getCategory();
        $category = Category::getByHandle($category);
        if (interface_exists('\Concrete\Core\Attribute\EntityInterface') &&
            $category instanceof \Concrete\Core\Attribute\EntityInterface) {
            // Version 8
            $key = new \Concrete\Core\Entity\Attribute\Key\UserKey();
            $key->setAttributeKeyHandle($ak->getHandle());
            $key->setAttributeKeyName($ak->getName());
            $key->setIsAttributeKeyInternal($ak->getIsInternal());
            $key->setIsAttributeKeyContentIndexed($ak->getIsIndexed());
            $key->setIsAttributeKeySearchable($ak->getIsSearchable());
            $key->setAttributeKeyDisplayedOnProfile($category->getDisplayedInProfile());
            $key->setAttributeKeyEditableOnProfile($category->getEditableInProfile());
            $key->setAttributeKeyRequiredOnProfile($category->getRequiredInProfile());
            $key->setAttributeKeyEditableOnRegister($category->getEditableInRegistration());
            $key->setAttributeKeyRequiredOnRegister($category->getRequiredInRegistration());
            $key->setAttributeKeyDisplayedOnMemberList($category->getDisplayedInMemberList());
        } else {
            // Legacy

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
                    'uakMemberListDisplay' => $category->getDisplayedInMemberList(),
                ), $pkg);
        }

        return $key;
    }
}
