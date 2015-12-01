<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Validator;

use Concrete\Core\Sharing\SocialNetwork\Link;

class SocialLinkValidator extends AbstractValidator
{
    public function skipItem()
    {
        $link = Link::getByServiceHandle($this->object->getService());

        return is_object($link);
    }
}
