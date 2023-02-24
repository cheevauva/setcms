<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Servant;

use SetCMS\ServantInterface;
use SetCMS\Module\Post\PostEntity;
use SetCMS\Module\Post\DAO\PostHasByIdDAO;
use SetCMS\Module\Post\DAO\PostSaveDAO;
use SetCMS\Module\Post\Exception\PostNotFoundException;

class PostUpdateServant implements ServantInterface
{

    use \SetCMS\DITrait;

    public PostEntity $post;

    public function serve(): void
    {
        $hasById = PostHasByIdDAO::make($this->factory());
        $hasById->id = $this->post->id;
        $hasById->serve();

        if (empty($hasById->isExists)) {
            throw new PostNotFoundException;
        }

        $saveEntity = PostSaveDAO::make($this->factory());
        $saveEntity->post = $this->post;
        $saveEntity->serve();
    }

}
