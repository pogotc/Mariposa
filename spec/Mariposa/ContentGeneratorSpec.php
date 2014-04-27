<?php

namespace spec\Mariposa;

use Mariposa\ContentProcessor\ContentProcessorInterface;
use Mariposa\Model\Post;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ContentGeneratorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Mariposa\ContentGenerator');
    }

    function it_can_turn_a_post_into_a_static_file()
    {
        $post = new Post();
        $post->content = "Hello everyone, and welcome to my blog";
        $this->processPost($post)->shouldReturn($post->content);
    }

    function it_can_run_content_processors(ContentProcessorInterface $processor)
    {
        $post = new Post();
        $post->content = "Hello *everyone*";

        $finalOutput = "Hello <strong>everyone</strong>";
        $processor->process($post->content)->willReturn($finalOutput);

        $this->addContentProcessor($processor);
        $this->processPost($post)->shouldReturn($finalOutput);
    }

}
