<?php

declare(strict_types=1);

namespace Module\UserSession\Mapper;

class UserSessionToRowMapper extends \UUA\Mapper
{

    use \SetCMS\Mapper\MapperEntityToRowTrait;
    use \Module\UserSession\Traits\UserSessionCallTrait;

    #[\Override]
    public function serve(): void
    {
        $this->mappingDefault($this->userSession);
        $this->row['device'] = mb_substr($this->userSession->device, 0, 50);
        $this->row['user_id'] = strval($this->userSession->userId);
        $this->row['date_expiries'] = $this->userSession->dateExpiries->format('Y-m-d H:i:s');
        $this->row['date_created'] = $this->userSession->dateCreated->format('Y-m-d H:i:s');
    }
}
