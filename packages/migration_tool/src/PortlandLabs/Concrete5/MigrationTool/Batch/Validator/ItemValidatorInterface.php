<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

interface ItemValidatorInterface
{
    public function __construct(Batch $batch);

    /**
     * @param $mixed
     *
     * @return MessageCollection
     */
    public function validate($mixed);
}
