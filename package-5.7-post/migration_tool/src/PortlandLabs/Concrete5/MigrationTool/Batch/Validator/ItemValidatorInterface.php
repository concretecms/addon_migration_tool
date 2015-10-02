<?php

namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

interface ItemValidatorInterface
{

    /**
     * @param Batch $batch
     * @param $mixed
     * @return MessageCollection
     */
    public function validate(Batch $batch, $mixed);
}