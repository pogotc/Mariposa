<?php

namespace Mariposa\Builder;

use Mariposa\Finder\Finder;
use Symfony\Component\Filesystem\Filesystem;

class SiteBuilder
{

    /**
     * @var \Mariposa\Finder\Finder
     */
    private $finder;
    /**
     * @var \Symfony\Component\Filesystem\Filesystem
     */
    private $filesystem;

    /**
     * Constructor.
     *
     * @param Finder $finder
     * @param Filesystem $filesystem
     */
    public function __construct(Finder $finder, Filesystem $filesystem)
    {

        $this->finder = $finder;
        $this->filesystem = $filesystem;
    }


    /**
     * Builds the site from the files in $sourcePath
     * and puts the built files into $dest
     *
     * @param $sourcePath
     * @param $dest
     */
    public function build($sourcePath, $dest)
    {
        $files = $this->finder->getSourceFiles($sourcePath);
        foreach ($files as $file) {
            $this->filesystem->dumpFile($dest ."/" . $file->getFilename(), $file->getContents());
        }
    }
}
