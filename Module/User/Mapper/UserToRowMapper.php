<?php

declare(strict_types=1);

namespace Module\User\Mapper;

class UserToRowMapper extends \UUA\Mapper
{

    use \SetCMS\Mapper\MapperEntityToRowTrait;
    use \Module\User\Traits\UserCallTrait;

    #[\Override]
    public function serve(): void
    {
        $this->mappingDefault($this->user);
        $this->row['username'] = $this->user->username;
        $this->row['password'] = $this->user->password;
        $this->row['role'] = $this->user->role->value;
        $this->row['email'] = $this->user->email;
    }
}
