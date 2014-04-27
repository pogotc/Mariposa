<?php


namespace Mariposa\ContentProcessor;


interface ContentProcessorInterface 
{

    /**
     * Performs some kind of content processing on $content.
     *
     * @param $content
     * @return String
     */
    public function process($content);
} 