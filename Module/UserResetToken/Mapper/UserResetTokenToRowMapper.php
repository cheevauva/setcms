<?php

declare(strict_types=1);

namespace Module\UserResetToken\Mapper;

class UserResetTokenToRowMapper extends \SetCMS\Entity\Mapper\EntityToRowMapper
{

    use \Module\UserResetToken\Traits\UserResetTokenCallTrait;

    #[\Override]
    public function serve(): void
    {
        $this->id($this->userResetToken);
        $this->row['user_id'] = $this->userResetToken->userId->uuid;
        $this->row['date_expired'] = $this->userResetToken->dateExpired->format('Y-m-d H:i:s');
        $this->row['token'] = $this->userResetToken->token;
    }
}
