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
             ->addOption("source", null, InputOption::VALUE_OPTIONAL, "defaults to current directory")
             ->addOption("dest", null, InputOption::VALUE_OPTIONAL, "defaults to current directory");

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getApplication()->getContainer();
        $siteBuilder = $container->get("mariposa.sitebuilder");

        $sourceFolder = $input->getOption("source");
        if (!$sourceFolder) {
            $sourceFolder = getcwd();
        }

        $destFolder = $input->getOption("dest");
        if (!$destFolder) {
            $destFolder = getcwd() . "/" . "site";
        }
        $siteBuilder->build($sourceFolder, $destFolder);

        $output->writeln("run....");
    }
}
