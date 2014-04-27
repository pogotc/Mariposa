<?php

namespace spec\Mariposa;

use Mariposa\Model\Post;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PathGeneratorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Mariposa\PathGenerator');
    }

    function it_can_generate_the_path_for_a_post()
    {
        $post = new Post();
        $post->title = "Hello World";
        $post->date = "2014-05-01";

        $this->getPathForPost($post)->shouldReturn("/2014/05/01/helloworld.html");
    }

    function it_can_deal_with_invalid_characters()
    {
        $post = new Post();
        $post->title = "*Hello* !! World%%";
        $post->date = "2010-12-07";

        $this->getPathForPost($post)->shouldReturn("/2010/12/07/helloworld.html");
    }
}
