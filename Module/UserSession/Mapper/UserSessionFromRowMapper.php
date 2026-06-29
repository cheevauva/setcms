<?php

declare(strict_types=1);

namespace Module\UserSession\Mapper;

use Module\UserSession\UserSessionEntity;
use Module\UserSession\Exception\UserSessionMapperNotFoundKeyInRowException;

class UserSessionFromRowMapper extends \SetCMS\Entity\Mapper\EntityFromRowMapper
{

    public UserSessionEntity $userSession;

    #[\Override]
    public function serve(): void
    {
        $this->userSession = new UserSessionEntity;
        $this->userSession->id = $this->uuid('id');
        $this->userSession->device = $this->string('device');
        $this->userSession->userId = $this->uuid('user_id');
        $this->userSession->dateExpiries = $this->dateTime('date_expiries');
        $this->id($this->userSession);
    }

    #[\Override]
    protected function notFoundKeyInRowException(string $key): UserSessionMapperNotFoundKeyInRowException
    {
        return new UserSessionMapperNotFoundKeyInRowException($key);
    }
}
