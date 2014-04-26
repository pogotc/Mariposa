<?php

namespace Mariposa\Console;

use Mariposa\Console\Command\BuildCommand;
use Symfony\Component\Console\Application as BaseApplication;

class Application extends BaseApplication
{

    public function __construct($version = 'UNKNOWN')
    {
        parent::__construct("mariposa", $version);

        $this->add(new BuildCommand());
    }
}