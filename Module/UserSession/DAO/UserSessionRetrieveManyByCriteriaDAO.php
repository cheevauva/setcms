<?php

declare(strict_types=1);

namespace Module\UserSession\DAO;

use Module\UserSession\UserSessionEntity;
use Module\UserSession\Mapper\UserSessionFromRowMapper;
use SetCMS\Entity\DAO\EntityRetrieveByCriteriaDAO;

/**
 * @extends EntityRetrieveByCriteriaDAO<UserSessionEntity>
 */
class UserSessionRetrieveManyByCriteriaDAO extends EntityRetrieveByCriteriaDAO
{

    use \Module\UserSession\Traits\UserSessionDbalDAOTrait;

    #[\Override]
    protected function rowToEntity(array $row): UserSessionEntity
    {
        return UserSessionFromRowMapper::call($this, $row)->entity;
    }
}
