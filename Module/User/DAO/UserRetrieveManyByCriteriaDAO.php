<?php

declare(strict_types=1);

namespace Module\User\DAO;

use Module\User\Entity\UserEntity;
use Module\User\Exception\UserNotFoundException;

class UserRetrieveManyByCriteriaDAO extends \SetCMS\DAO\EntityRetrieveManyByCriteriaDAO
{

    use UserCommonDAO;

    public string $email;
    public string $username;

    /**
     * @var UserEntity[]
     */
    public array $users;
    public ?UserEntity $user;

    #[\Override]
    public function serve(): void
    {
        if (isset($this->username)) {
            $this->criteria['username'] = $this->username;
        }

        if (isset($this->email)) {
            $this->criteria['email'] = $this->email;
        }

        parent::serve();

        $this->users = UserEntity::manyAs($this->entities);
        $this->user = $this->first ? UserEntity::as($this->first) : null;
    }

    #[\Override]
    protected function notFoundExcecption(): UserNotFoundException
    {
        return new UserNotFoundException();
    }
}
