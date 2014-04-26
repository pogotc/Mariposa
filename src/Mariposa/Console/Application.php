<?php

namespace Mariposa\Console;

use Mariposa\Console\Command\BuildCommand;
use Mariposa\DependencyInjection\MariposaExtension;
use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class Application extends BaseApplication
{

    private $container;

    public function __construct($version = 'UNKNOWN')
    {
        parent::__construct("mariposa", $version);

        $this->setupCommands();
        $this->setupContainer();
    }

    public function getContainer()
    {
        return $this->container;
    }

    private function setupContainer()
    {
        $this->container = new ContainerBuilder();

        $extension = new MariposaExtension();
        $this->container->registerExtension($extension);
        $this->container->loadFromExtension($extension->getAlias());
        $this->container->compile();
    }

    private function setupCommands()
    {
        $this->add(new BuildCommand());
    }
}