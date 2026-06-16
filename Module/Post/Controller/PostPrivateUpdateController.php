<?php

declare(strict_types=1);

namespace Module\Post\Controller;

use SetCMS\Controller\ControllerViaPSR7;
use Module\Post\Entity\PostEntity;
use Module\Post\DAO\PostGetByIdDAO;
use Module\Post\DAO\PostUpdateDAO;
use Module\Post\View\PostPrivateUpdateView;
use Module\Post\Mapper\PostFromRequestMapper;

class PostPrivateUpdateController extends ControllerViaPSR7
{

    protected PostEntity $post;
    protected PostEntity $newPost;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            PostFromRequestMapper::class,
            PostGetByIdDAO::class,
            PostUpdateDAO::class,
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            PostPrivateUpdateView::class,
        ];
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof PostGetByIdDAO) {
            $object->id = $this->newPost->id;
        }

        if ($object instanceof PostUpdateDAO) {
            $object->post = $this->post;
            $object->post->slug = $this->newPost->slug;
            $object->post->title = $this->newPost->title;
            $object->post->message = $this->newPost->message;
        }

        if ($object instanceof PostPrivateUpdateView) {
            $object->post = $this->post;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);
        
        if ($object instanceof PostFromRequestMapper) {
            $this->newPost = $object->post;
        }
        
        if ($object instanceof PostGetByIdDAO) {
            $this->post = $object->post;
        }
    }
}
