<?php

declare(strict_types=1);

namespace Module\User\Mapper;

class UserToRowMapper extends \SetCMS\Entity\Mapper\EntityToRowMapper
{

    use \Module\User\Traits\UserCallTrait;

    #[\Override]
    public function serve(): void
    {
        $this->id($this->user);
        $this->row['username'] = $this->user->username;
        $this->row['password'] = $this->user->password;
        $this->row['user_role'] = $this->user->role->value;
        $this->row['email'] = $this->user->email;
    }
}
