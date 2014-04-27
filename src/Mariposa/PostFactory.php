<?php


namespace Mariposa;


use Mariposa\Model\Post;
use Symfony\Component\Finder\SplFileInfo;

class PostFactory
{

    public function createPostFromFile(SplFileInfo $file)
    {
        $post = new Post();
        $post->date = $this->getPostDate($file);
        $post->content = $file->getContents();
        $parameters = $this->parseParameterBlock($post);
        $this->applyParametersToPost($parameters, $post);

        return $post;
    }

    private function getPostDate($file)
    {
        return str_replace(".markdown", "", $file->getFilename());
    }

    private function parseParameterBlock($post)
    {
        if (preg_match('/---(.*?)---/ms', $post->content, $matches)) {
            return $this->parseParameters($matches[1]);
        }
        return array();
    }

    private function parseParameters($parameterBlock)
    {
        $parameters = array();
        if (preg_match_all("/([\w]+):([\w ]+)/", $parameterBlock, $parsedParameters)) {
            foreach ($parsedParameters[1] as $key => $fieldName) {
                $parameters[$fieldName] = trim($parsedParameters[2][$key]);
            }
        }

        return $parameters;
    }


    private function applyParametersToPost($parameters, $post)
    {
        if (isset($parameters['title'])) {
            $post->title = $parameters['title'];
        }
    }
} 