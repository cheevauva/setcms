<?php

declare(strict_types=1);

namespace Module\Post\Controller;

use SetCMS\Controller\ControllerViaPSR7;
use Module\Post\DAO\PostRetrieveManyByCriteriaDAO;
use Module\Post\Entity\PostEntity;
use Module\Post\View\PostPublicReadBySlugView;
use Module\Post\Exception\PostNotFoundException;

class PostPublicReadBySlugController extends ControllerViaPSR7
{

    protected string $slug;
    protected PostEntity $post;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            PostRetrieveManyByCriteriaDAO::class,
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            PostPublicReadBySlugView::class,
        ];
    }

    #[\Override]
    protected function process(): void
    {
        $this->slug = $this->validation($this->params)->string('slug')->notEmpty()->notQuiet()->val();
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof PostRetrieveManyByCriteriaDAO) {
            $object->slug = $this->slug;
            $object->limit = 1;
            $object->throwIfEmpty = new PostNotFoundException();
        }

        if ($object instanceof PostPublicReadBySlugView) {
            $object->post = $this->post;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof PostRetrieveManyByCriteriaDAO) {
            $this->post = $object->first();
        }
    }
}
