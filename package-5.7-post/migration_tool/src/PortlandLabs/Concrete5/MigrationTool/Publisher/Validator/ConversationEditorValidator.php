<?php

namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Validator;

use Concrete\Core\Conversation\Editor\Editor;
use Concrete\Core\Page\Template;

class ConversationEditorValidator extends AbstractValidator
{

    public function skipItem()
    {
        $editor = Editor::getByHandle($this->object->getHandle());
        return is_object($editor);
    }

}
