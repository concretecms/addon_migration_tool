<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Validator;

use Concrete\Core\Page\Stack\Stack;
use Concrete\Core\Page\Page;;

class StackValidator extends AbstractValidator
{
    public function skipItem()
    {
        $c = Stack::getByPath($this->object->getPath());
        if (is_object($c)) {
            $blocks = $c->getBlocks();
            if (count($blocks)) {
                return true;
            }
        }

        return false;
    }
}
