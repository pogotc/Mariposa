<?php

namespace Mariposa;

use Mariposa\Model\Post;

class PathGenerator
{

    /**
     * Generates the full pathname for a post based on the title and date
     *
     * @param Model\Post $post
     * @return String
     */
    public function getPathForPost(Post $post)
    {
        $path = "/".str_replace("-", "/", $post->date) . "/";
        $path.= strtolower(preg_replace('~\W~', '', $post->title));
        $path.= ".html";
        return $path;
    }
}
