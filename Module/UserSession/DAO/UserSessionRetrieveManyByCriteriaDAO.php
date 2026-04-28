<?php

declare(strict_types=1);

namespace Module\UserSession\DAO;

use Module\UserSession\UserSessionEntity;
use Module\UserSession\Exception\UserSessionNotFoundException;
use Module\UserSession\Mapper\UserSessionFromRowMapper;

class UserSessionRetrieveManyByCriteriaDAO extends \UUA\DAO
{

    use \SetCMS\DAO\DAOEntityRetrieveByCriteriaTrait;
    use \Module\UserSession\Traits\UserSessionDbalDAOTrait;

    /**
     * @var UserSessionEntity[]
     */
    public array $userSessions;
    public UserSessionEntity $userSession;
    public ?UserSessionEntity $userSessionOrNull;

    #[\Override]
    protected function entitiesNotFoundException(): \Throwable
    {
        return new UserSessionNotFoundException();
    }

    #[\Override]
    protected function entityExpectOneButReceivedTooMuchException(): \Throwable
    {
        return new UserSessionNotFoundException();
    }

    #[\Override]
    protected function entityNotFoundException(): \Throwable
    {
        return new UserSessionNotFoundException();
    }

    #[\Override]
    protected function handleRows(array $rows): void
    {
        $this->userSessions = array_map(fn($row) => UserSessionFromRowMapper::call($this->container, $row)->userSession, $rows);
        $this->userSessions ? $this->userSession = $this->userSessionOrNull = $this->userSessions[0] : null;
    }
}
