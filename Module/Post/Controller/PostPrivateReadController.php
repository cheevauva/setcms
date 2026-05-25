<?php

declare(strict_types=1);

namespace Module\Post\Controller;

use SetCMS\UUID;
use SetCMS\Controller\ControllerViaPSR7;
use Module\Post\Entity\PostEntity;
use Module\Post\DAO\PostGetByIdDAO;
use Module\Post\View\PostPrivateReadView;

class PostPrivateReadController extends ControllerViaPSR7
{

    protected PostEntity $post;
    protected UUID $id;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            PostGetByIdDAO::class,
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
    protected function fromRequest(): void
    {
        $this->id = $this->validationParams()->uuid('id')->notEmpty()->notQuiet()->val();
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof PostGetByIdDAO) {
            $object->id = $this->id;
        }

        if ($object instanceof PostPrivateReadView) {
            $object->post = $this->post;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof PostGetByIdDAO) {
            $this->post = $object->post;
        }
    }
}
