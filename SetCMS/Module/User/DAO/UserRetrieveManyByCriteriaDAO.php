<?php

declare(strict_types=1);

namespace SetCMS\Module\User\DAO;

use SetCMS\Module\User\Entity\UserEntity;

class UserRetrieveManyByCriteriaDAO extends \SetCMS\Common\DAO\EntityRetrieveManyByCriteriaDAO
{

    public string $username;

    /**
     * @var UserEntity[]
     */
    public array $users;
    public ?UserEntity $user;

    use UserCommonDAO;

    public function serve(): void
    {
        if (isset($this->username)) {
            $this->criteria['username'] = $this->username;
        }

        parent::serve();

        $this->users = $this->entities;
        $this->user = $this->first ? UserEntity::as($this->first) : null;
    }
}
