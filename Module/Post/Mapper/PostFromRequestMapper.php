<?php

declare(strict_types=1);

namespace Module\Post\Mapper;

use Module\Post\Entity\PostEntity;

class PostFromRequestMapper extends \SetCMS\Request\Mapper\RequestMapper
{

    public protected(set) PostEntity $post;

    #[\Override]
    public function serve(): void
    {
        $body = $this->validationBody();
        $body->array('post')->notEmpty()->validate();

        $this->post = new PostEntity();
        $this->post->id = $body->uuid('post.id')->val();
        $this->post->slug = $body->string('post.slug')->notEmpty()->val();
        $this->post->title = $body->string('post.title')->notEmpty()->val();
        $this->post->message = $body->string('post.message')->notEmpty()->val();
    }
}
