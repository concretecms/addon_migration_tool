<?php
class MigrationToolTestCase extends PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $l = new \Symfony\Component\ClassLoader\Psr4ClassLoader();
        $l->addPrefix('PortlandLabs\Concrete5\MigrationTool', DIR_PACKAGES . '/migration_tool/src/PortlandLabs/Concrete5/MigrationTool');
        $l->register();
    }

}