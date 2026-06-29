<?php

declare(strict_types=1);

namespace Module\UserResetToken\DAO;

use SetCMS\Database\DatabaseQueryBuilder;
use Module\UserResetToken\Exception\UserResetTokensNotFoundException;
use Module\UserResetToken\Exception\UserResetTokenNotFoundException;
use Module\UserResetToken\Exception\UserResetTokenExpectOneButReceivedTooMuchException;
use Module\UserResetToken\Entity\UserResetTokenEntity;
use Module\UserResetToken\Mapper\UserResetTokenFromRowMapper;
use SetCMS\UUID;

class UserResetTokenRetrieveManyByCriteriaDAO extends \SetCMS\Entity\DAO\EntityRetrieveByCriteriaDAO
{

    use \Module\UserResetToken\Traits\UserResetTokenDbalDAOTrait;

    /**
     * @var UserResetTokenEntity[]
     */
    public protected(set) array $userResetTokens;
    public protected(set) UserResetTokenEntity $userResetToken;
    public protected(set) ?UserResetTokenEntity $userResetTokenOrNull = null;
    public UUID $userId;

    #[\Override]
    protected function handleRows(array $rows): void
    {
        $this->userResetTokens = array_map(fn($row) => UserResetTokenFromRowMapper::call($this->container, $row)->userResetToken, $rows);
        $this->userResetTokens ? $this->userResetToken = $this->userResetTokenOrNull = $this->userResetTokens[0] : null;
    }

    protected function createQb(): DatabaseQueryBuilder
    {
        $qb = $this->createQuery();

        if (isset($this->userId)) {
            $qb->andWhere('user_id = :userId');
            $qb->setParameter('userId', $this->userId->uuid);
        }

        return $qb;
    }

    #[\Override]
    protected function entitiesNotFoundException(): \Throwable
    {
        return new UserResetTokensNotFoundException();
    }

    #[\Override]
    protected function entityExpectOneButReceivedTooMuchException(): \Throwable
    {
        return new UserResetTokenExpectOneButReceivedTooMuchException();
    }

    #[\Override]
    protected function entityNotFoundException(): \Throwable
    {
        return new UserResetTokenNotFoundException();
    }
}
