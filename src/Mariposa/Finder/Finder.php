<?php

namespace Mariposa\Finder;

use Symfony\Component\Finder\Finder as BaseFinder;

class Finder extends BaseFinder
{
    public function getSourceFiles($sourceFolder)
    {
        return $this->files()
                    ->name("*.html")
                    ->in($sourceFolder);
    }
}
