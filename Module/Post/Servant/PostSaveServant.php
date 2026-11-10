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
    protected function run(): void
    {
        if (PostHasByIdDAO::call($this, $this->post->id)->isExists) {
            PostUpdateDAO::call($this, $this->post);
        } else {
            PostCreateDAO::call($this, $this->post);
        }
    }
}
