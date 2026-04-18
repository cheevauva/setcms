<?php

declare(strict_types=1);

namespace Module\Post\Servant;

use Module\Post\DAO\PostHasByIdDAO;
use Module\Post\DAO\PostCreateDAO;
use Module\Post\DAO\PostUpdateDAO;

class PostSaveServant extends \UUA\Servant
{

    use \Module\Post\Traits\PostCallTrait;

    #[\Override]
    public function serve(): void
    {
        if (PostHasByIdDAO::call($this->container, $this->post->id)->isExists) {
            PostUpdateDAO::call($this->container, $this->post);
        } else {
            PostCreateDAO::call($this->container, $this->post);
        }
    }
}
