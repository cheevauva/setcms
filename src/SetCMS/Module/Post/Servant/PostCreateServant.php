<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Servant;

use SetCMS\ServantInterface;
use SetCMS\Module\Post\PostEntity;
use SetCMS\Module\Post\DAO\PostHasByIdDAO;
use SetCMS\Module\Post\DAO\PostSaveDAO;
use SetCMS\Module\Post\Exception\PostAlreadyExistsException;

class PostCreateServant implements ServantInterface
{

    use \SetCMS\DITrait;

    public PostEntity $post;

    public function serve(): void
    {
        $hasEntityById = PostHasByIdDAO::make($this->factory());
        $hasEntityById->id = $this->post->id;
        $hasEntityById->serve();

        if ($hasEntityById->isExists) {
            throw new PostAlreadyExistsException;
        }

        $saveEntity = PostSaveDAO::make($this->factory());
        $saveEntity->post = $this->post;
        $saveEntity->serve();
    }

}
