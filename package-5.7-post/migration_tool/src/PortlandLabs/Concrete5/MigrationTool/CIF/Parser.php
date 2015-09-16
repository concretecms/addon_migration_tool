<?php

namespace PortlandLabs\Concrete5\MigrationTool\CIF;


class Parser
{

    protected $simplexml;

    public function __construct($file)
    {
        $this->simplexml = simplexml_load_file($file);
    }


}
