<?php

namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Validator;

use PortlandLabs\Concrete5\MigrationTool\Publisher\PublishableInterface;

abstract class AbstractValidator implements ValidatorInterface
{

    protected $object;

    public function __construct(PublishableInterface $object)
    {
        $this->object = $object;
    }


}
