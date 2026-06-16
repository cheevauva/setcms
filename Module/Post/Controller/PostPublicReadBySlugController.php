<?php

declare(strict_types=1);

namespace Module\Post\Controller;

use SetCMS\Controller\ControllerViaPSR7;
use Module\Post\DAO\PostRetrieveManyByCriteriaDAO;
use Module\Post\Entity\PostEntity;
use Module\Post\View\PostPublicReadBySlugView;
use Module\Post\Mapper\PostSlugFromRequestMapper;

class PostPublicReadBySlugController extends ControllerViaPSR7
{

    protected string $slug;
    protected PostEntity $post;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            PostSlugFromRequestMapper::class,
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
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof PostRetrieveManyByCriteriaDAO) {
            $object->slug = $this->slug;
            $object->limit = 1;
            $object->expectOne = true;
            $object->allowEmptyResult = false;
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
            $this->post = $object->post;
        }

        if ($object instanceof PostSlugFromRequestMapper) {
            $this->slug = $object->slug;
        }
    }
}
