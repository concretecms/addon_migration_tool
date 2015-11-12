<?php

namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Validator;

use Concrete\Core\Attribute\Key\CollectionKey;
use Concrete\Core\Attribute\Key\FileKey;
use Concrete\Core\Attribute\Key\UserKey;
use Concrete\Core\Permission\Key\Key;

class PermissionKeyValidator extends AbstractValidator
{

    public function skipItem()
    {
        $key = Key::getByHandle($this->object->getHandle());
        return is_object($key);
    }

}
