<?php

declare(strict_types=1);

namespace Module\User\DAO;

use Module\User\Entity\UserEntity;
use Module\User\Exception\UserNotFoundException;
use Module\User\Mapper\UserFromRowMapper;
use SetCMS\Database\DatabaseQueryBuilder;

class UserRetrieveManyByCriteriaDAO extends \SetCMS\Entity\DAO\EntityRetrieveByCriteriaDAO
{

    use \Module\User\Traits\UserDbalTrait;

    public string $email;
    public string $username;

    /**
     * @var UserEntity[]
     */
    public array $users;
    public UserEntity $user;
    public ?UserEntity $userOrNull = null;

    protected function createQb(): DatabaseQueryBuilder
    {
        $qb = $this->createQuery();

        if (isset($this->username)) {
            $qb->andWhere('username = :username');
            $qb->setParameter('username', $this->username);
        }

        if (isset($this->email)) {
            $qb->andWhere('email = :email');
            $qb->setParameter('email', $this->email);
        }

        return $qb;
    }

    #[\Override]
    protected function entitiesNotFoundException(): \Throwable
    {
        return new UserNotFoundException();
    }

    #[\Override]
    protected function entityExpectOneButReceivedTooMuchException(): \Throwable
    {
        return new UserNotFoundException();
    }

    #[\Override]
    protected function entityNotFoundException(): \Throwable
    {
        return new UserNotFoundException();
    }

    #[\Override]
    protected function handleRows(array $rows): void
    {
        $this->users = array_map(fn($row) => UserFromRowMapper::call($this->container, $row)->user, $rows);
        $this->users ? $this->user = $this->userOrNull = $this->users[0] : null;
    }
}
