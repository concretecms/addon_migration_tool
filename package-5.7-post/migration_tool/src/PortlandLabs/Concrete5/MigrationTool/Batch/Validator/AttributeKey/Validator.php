<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\AttributeKey;

use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ItemValidatorInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Message;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\MessageCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\UnknownAttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

class Validator implements ItemValidatorInterface
{

    public function validate(Batch $batch, $key)
    {
        $messages = new MessageCollection();
        if ($key instanceof UnknownAttributeKey) {
            $messages->add(
                new Message(t('Attribute key is of an unknown type. It may not be imported properly.'))
            );
        }
        return $messages;
    }
}