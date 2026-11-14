<?php

declare(strict_types=1);

namespace Module\UserResetToken\DAO;

use SetCMS\Database\DatabaseQueryBuilder;
use SetCMS\Entity\DAO\EntityRetrieveByCriteriaDAO;
use Module\UserResetToken\Entity\UserResetTokenEntity;
use Module\UserResetToken\Mapper\UserResetTokenFromRowMapper;
use SetCMS\UUID;

/**
 * @extends EntityRetrieveByCriteriaDAO<UserResetTokenEntity>
 */
class UserResetTokenRetrieveManyByCriteriaDAO extends EntityRetrieveByCriteriaDAO
{

    use \Module\UserResetToken\Traits\UserResetTokenDbalDAOTrait;

    public UUID $userId;

    #[\Override]
    protected function createQb(): DatabaseQueryBuilder
    {
        $qb = parent::createQb();

        if (isset($this->userId)) {
            $qb->andWhere('user_id = :userId');
            $qb->setParameter('userId', $this->userId->uuid);
        }

        return $qb;
    }


    #[\Override]
    protected function rowToEntity(array $row): UserResetTokenEntity
    {
        return UserResetTokenFromRowMapper::call($this, $row)->entity;
    }
}
