<?php

namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Validator;

use Concrete\Core\Captcha\Library;
use Concrete\Core\Editor\Snippet;
use Concrete\Core\Package\Package;

class PackageValidator extends AbstractValidator
{

    public function skipItem()
    {
        $pkg = Package::getByHandle($this->object->getHandle());
        return is_object($pkg);
    }

}
