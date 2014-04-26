<?php

namespace Mariposa\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class BuildCommand extends Command
{
    protected function configure()
    {
        $this->setName("build")
             ->setDescription("Builds a site")
             ->addOption("source", null, InputOption::VALUE_OPTIONAL, "defaults to current directory");

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Coming soon....");
    }
}
