<?php

namespace Mariposa\Builder;

use Mariposa\ContentGenerator;
use Mariposa\Finder\Finder;
use Mariposa\Model\Post;
use Mariposa\PathGenerator;
use Mariposa\PostFactory;
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
     * @var \Mariposa\ContentGenerator
     */
    private $contentGenerator;
    /**
     * @var \Mariposa\PathGenerator
     */
    private $pathGenerator;
    /**
     * @var \Mariposa\PostFactory
     */
    private $postFactory;

    /**
     * Constructor.
     *
     * @param Finder $finder
     * @param Filesystem $filesystem
     */
    public function __construct(Finder $finder, Filesystem $filesystem, ContentGenerator $contentGenerator, PathGenerator $pathGenerator, PostFactory $postFactory)
    {

        $this->finder = $finder;
        $this->filesystem = $filesystem;
        $this->contentGenerator = $contentGenerator;
        $this->pathGenerator = $pathGenerator;
        $this->postFactory = $postFactory;
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

        $posts = $this->finder->getPostsFiles($sourcePath);
        foreach ($posts as $postFile) {
            $post = $this->postFactory->createPostFromFile($postFile);
            $path = $this->pathGenerator->getPathForPost($post);

            $this->filesystem->dumpFile($dest . $path, $post->content);



//            $this->applyContentProcessors($post);
//            $this->sendPostToOutput($post);
        }

    }
}
