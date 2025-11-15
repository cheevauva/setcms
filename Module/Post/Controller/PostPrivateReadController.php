<?php

declare(strict_types=1);

namespace Module\Post\Controller;

use SetCMS\UUID;
use Module\Post\PostEntity;
use Module\Post\DAO\PostRetrieveManyByCriteriaDAO;
use Module\Post\View\PostPrivateReadView;

class PostPrivateReadController extends PostPrivateController
{

    protected PostEntity $post;
    protected UUID $id;

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
            PostPrivateReadView::class,
        ];
    }

    #[\Override]
    protected function process(): void
    {
        $validation = $this->validation($this->params);

        $this->id = $validation->uuid('id')->notEmpty()->notQuiet()->val();
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof PostRetrieveManyByCriteriaDAO) {
            $object->id = $this->id;
            $object->orThrow = true;
        }

        if ($object instanceof PostPrivateReadView) {
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
