<?php

declare(strict_types=1);

namespace Module\User\DAO;

use Module\User\Entity\UserEntity;
use SetCMS\Entity\DAO\EntityRetrieveByCriteriaDAO;
use Module\User\Mapper\UserFromRowMapper;
use SetCMS\Database\DatabaseQueryBuilder;

/**
 * @extends EntityRetrieveByCriteriaDAO<UserEntity>
 */
class UserRetrieveManyByCriteriaDAO extends EntityRetrieveByCriteriaDAO
{

    use \Module\User\Traits\UserDbalTrait;

    public string $email;
    public string $username;

    protected function createQb(): DatabaseQueryBuilder
    {
        $qb = parent::createQb();

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
    protected function rowToEntity(array $row): UserEntity
    {
        return UserFromRowMapper::call($this, $row)->entity;
    }
}
