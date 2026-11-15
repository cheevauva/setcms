<?php

declare(strict_types=1);

namespace Module\ACL\VO;

use Psr\Http\Message\ServerRequestInterface;

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

    public static function fromRequest(ServerRequestInterface $request, string $name = 'currentUserRole'): static
    {
        return static::as($request->getAttribute($name) ?? throw new \Exception(sprintf('Аттрибут %s не задан', $name)));
    }
}
