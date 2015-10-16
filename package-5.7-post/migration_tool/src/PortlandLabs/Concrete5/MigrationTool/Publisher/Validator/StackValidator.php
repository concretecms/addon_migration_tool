<?php

namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Validator;

use Concrete\Core\Page\Stack\Stack;

class StackValidator extends AbstractValidator
{

    public function skipItem()
    {
        return false;
    }

}
