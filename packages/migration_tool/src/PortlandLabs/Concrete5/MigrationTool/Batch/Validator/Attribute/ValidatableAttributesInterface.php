<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Attribute;

use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\AbstractValidator;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\MessageCollection;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page\Content\Factory;

defined('C5_EXECUTE') or die("Access Denied.");

interface ValidatableAttributesInterface
{

    function getAttributeValidatorDriver();

}
