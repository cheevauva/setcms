<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Controller;

use SetCMS\Module\Post\DAO\PostRetrieveManyByCriteriaDAO;
use SetCMS\Module\Post\View\PostPrivateIndexView;

class PostPrivateIndexController extends PostPrivateController
{

    protected array $entities = [];

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
            $this->entities = $object->entities;
        }
    }

    #[\Override]
    public function to(object $object): void
    {
        if ($object instanceof PostPrivateIndexView) {
            $object->entities = $this->entities;
        }
    }
}
