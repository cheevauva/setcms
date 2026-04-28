<?php

declare(strict_types=1);

namespace Module\UserResetToken\Mapper;

class UserResetTokenToRowMapper extends \UUA\Mapper
{

    use \SetCMS\Mapper\MapperEntityToRowTrait;
    use \Module\UserResetToken\Traits\UserResetTokenCallTrait;

    #[\Override]
    public function serve(): void
    {
        $this->mappingDefault($this->userResetToken);
        $this->row['user_id'] = $this->userResetToken->userId->uuid;
        $this->row['date_expired'] = $this->userResetToken->dateExpired->format('Y-m-d H:i:s');
        $this->row['token'] = $this->userResetToken->token;
    }
}
