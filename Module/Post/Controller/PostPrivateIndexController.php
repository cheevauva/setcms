<?php

declare(strict_types=1);

namespace Module\Post\Controller;

use SetCMS\Controller\ControllerViaPSR7;
use Module\Post\DAO\PostRetrieveManyByCriteriaDAO;
use Module\Post\View\PostPrivateIndexView;
use Module\Post\PostEntity;

class PostPrivateIndexController extends ControllerViaPSR7
{

    /**
     * @var PostEntity[]
     */
    protected array $posts = [];

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
            PostPrivateIndexView::class,
        ];
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof PostRetrieveManyByCriteriaDAO) {
            $this->posts = $object->posts;
        }
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);
        
        if ($object instanceof PostPrivateIndexView) {
            $object->posts = $this->posts;
        }
    }
}
