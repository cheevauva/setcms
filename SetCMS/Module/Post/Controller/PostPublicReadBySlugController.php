<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Controller;

use SetCMS\ControllerViaPSR7;
use SetCMS\Module\Post\DAO\PostRetrieveManyByCriteriaDAO;
use SetCMS\Module\Post\PostEntity;
use SetCMS\Module\Post\View\PostPublicReadBySlugView;
use SetCMS\Application\Router\RouterMatchDTO;

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
        $routerMatch = RouterMatchDTO::as($this->ctx['routerMatch']);

        $this->slug = $this->validation($routerMatch->params)->string('slug')->notEmpty()->notQuiet()->val();
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
            $object->post = $this->post;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof PostRetrieveManyByCriteriaDAO) {
            $this->post = PostEntity::as($object->post);
        }
    }
}
