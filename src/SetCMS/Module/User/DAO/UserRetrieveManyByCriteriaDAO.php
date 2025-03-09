<?php

declare(strict_types=1);

namespace SetCMS\Module\User\DAO;

use SetCMS\Module\User\Entity\UserEntity;

class UserRetrieveManyByCriteriaDAO extends \SetCMS\Common\DAO\Entity\EntityRetrieveManyByCriteriaDAO
{

    public ?UserEntity $user = null;
    public string $username;

    use UserCommonDAO;

    public function serve(): void
    {
        $this->criteria = [
            'username' => $this->username,
            'deleted' => 0,
        ];

        parent::serve();

        $this->user = $this->entity;
    }
}
