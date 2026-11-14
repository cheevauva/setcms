<?php

declare(strict_types=1);

namespace Module\Post\Servant;

use Module\Post\DAO\PostHasByIdDAO;
use Module\Post\DAO\PostCreateDAO;
use Module\Post\DAO\PostUpdateDAO;

class PostSaveServant extends \UUA\Servant
{

    use \SetCMS\Entity\Traits\EntityCallTrait;

    #[\Override]
    protected function run(): void
    {
        if (PostHasByIdDAO::call($this, $this->entity->id)->isExists) {
            PostUpdateDAO::call($this, $this->entity);
        } else {
            PostCreateDAO::call($this, $this->entity);
        }
    }
}
