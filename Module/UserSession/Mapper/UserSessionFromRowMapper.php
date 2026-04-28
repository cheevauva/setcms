<?php

declare(strict_types=1);

namespace Module\UserSession\Mapper;

use Module\UserSession\UserSessionEntity;

class UserSessionFromRowMapper extends \UUA\Mapper
{

    use \SetCMS\Mapper\MapperEntityFromRowTrait;

    public UserSessionEntity $userSession;

    #[\Override]
    public function serve(): void
    {
        $this->userSession = new UserSessionEntity;
        $this->userSession->device = $this->string('device');
        $this->userSession->userId = $this->uuid('user_id');
        $this->userSession->dateExpiries = $this->dateTime('date_expiries');
        $this->mappingDefault($this->userSession);
    }

    #[\Override]
    protected function notFoundKeyInRowException(string $key): \Throwable
    {
        return new \Exception($key);
    }
}
