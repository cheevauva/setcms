<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Controller;

use SetCMS\Module\Post\PostEntity;
use SetCMS\Module\Post\Servant\PostCreateServant;
use SetCMS\Attribute\Http\RequestMethod;
use SetCMS\Module\Post\View\PostPrivateCreateView;

#[RequestMethod('POST')]
class PostPrivateCreateController extends PostPrivateController
{

    protected PostEntity $post;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            PostCreateServant::class,
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            PostPrivateCreateView::class,
        ];
    }

    #[\Override]
    protected function process(): void
    {
        $body = $this->request->getParsedBody() ?? [];

        $validation = $this->validation($body);
        $validation->array('post')->notEmpty()->validate();

        $this->post = new PostEntity();
        $this->post->id = $validation->uuid('post.id')->val();
        $this->post->title = $validation->string('post.title')->notEmpty()->val();
        $this->post->slug = $validation->string('post.slug')->notEmpty()->val();
        $this->post->message = $validation->string('post.message')->notEmpty()->val();
    }

    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof PostCreateServant) {
            $object->post = $this->post;
        }

        if ($object instanceof PostPrivateCreateView) {
            $object->post = $this->post;
        }
    }
}
