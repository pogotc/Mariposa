<?php

namespace Mariposa\Finder;

use Symfony\Component\Finder\Finder as BaseFinder;

class Finder extends BaseFinder
{
    public function getSourceFiles($sourceFolder)
    {
        return $this->files()
            ->name("*.html")
            ->exclude("site")
            ->in($sourceFolder);
    }

    public function getPostsFiles($sourceFolder)
    {
        return $this->files()
            ->name("*.markdown")
            ->exclude("site")
            ->in($sourceFolder);
    }
}
