<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Servant;

use SetCMS\Application\Contract\ContractServant;
use SetCMS\Module\Post\PostEntity;
use SetCMS\Module\Post\DAO\PostRetrieveByIdDAO;
use SetCMS\Module\Post\DAO\PostSaveDAO;
use SetCMS\Module\Post\Exception\PostNotFoundException;

class PostDeleteServant implements ContractServant
{

    use \SetCMS\Traits\DITrait;

    public ?PostEntity $post = null;
    public ?UUID $id = null;

    public function serve(): void
    {
        $retrieveById = PostRetrieveByIdDAO::make($this->factory());
        $retrieveById->id = $this->id ?? $this->post->id;
        $retrieveById->serve();

        if (!$retrieveById->entity) {
            throw new PostNotFoundException;
        }

        $entity = $retrieveById->post;
        $entity->deleted = true;

        $save = PostSaveDAO::make($this->factory());
        $save->entity = $entity;
        $save->serve();

        $this->entity = $entity;
    }

}
