<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Attribute;

defined('C5_EXECUTE') or die("Access Denied.");

interface ValidatableAttributesInterface
{

    function getAttributeValidatorDriver();

}
