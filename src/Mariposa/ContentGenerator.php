<?php

namespace Mariposa;

use Mariposa\ContentProcessor\ContentProcessorInterface;
use Mariposa\Model\Post;

class ContentGenerator
{

    private $contentProcessors;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->contentProcessors = array();
    }

    /**
     * Adds a content processor to the list available
     *
     * @param ContentProcessorInterface $contentProcessor
     */
    public function addContentProcessor(ContentProcessorInterface $contentProcessor)
    {
        $this->contentProcessors[]= $contentProcessor;
    }

    /**
     * Processes $post by running it through the content processors
     *
     * @param Post $post
     * @return String
     */
    public function processPost(Post $post)
    {
        return $this->applyContentProcessors($post->content);
    }

    /**
     * Applies the processors to $output
     *
     * @param $output
     * @return mixed
     */
    private function applyContentProcessors($output)
    {
        if (count($this->contentProcessors)) {
            foreach ($this->contentProcessors as $contentProcessor) {
                $output = $contentProcessor->process($output);
            }
        }
        return $output;
    }


}
