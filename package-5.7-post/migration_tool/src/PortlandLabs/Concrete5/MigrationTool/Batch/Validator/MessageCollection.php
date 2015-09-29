<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator;

use Doctrine\Common\Collections\ArrayCollection;

defined('C5_EXECUTE') or die("Access Denied.");

class MessageCollection extends ArrayCollection
{

    public function getFormatter()
    {
        return new MessageCollectionFormatter($this);
    }

}