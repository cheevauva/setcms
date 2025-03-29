<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Controller;

use SetCMS\Controller;
use SetCMS\Module\Post\DAO\PostRetrieveManyByCriteriaDAO;
use SetCMS\Module\Post\PostEntity;
use SetCMS\Module\Post\View\PostPublicReadBySlugView;
use SetCMS\Module\Post\View\PostPublicNotFoundView;

class PostPublicReadBySlugController extends Controller
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
            PostPublicNotFoundView::class,
            PostPublicReadBySlugView::class,
        ];
    }

    #[\Override]
    protected function mapper(): void
    {
        $validationAttr = $this->validation($this->request->getAttributes());

        $this->slug = $validationAttr->string('slug')->notEmpty()->val();
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof PostRetrieveManyByCriteriaDAO) {
            $object->slug = $this->slug;
            $object->orThrow = true;
        }


        if ($object instanceof PostPublicReadBySlugView) {
            $object->post = $this->post ?? null;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof PostRetrieveManyByCriteriaDAO) {
            $this->post = $object->post;
        }
    }

}
