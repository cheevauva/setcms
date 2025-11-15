<?php

declare(strict_types=1);

namespace SetCMS\ACL\VO;

class ACLRoleVO extends \UUA\VO
{
    public function __construct(protected string $role)
    {
        ;
    }

    public function __toString(): string
    {
        return $this->role;
    }
}
