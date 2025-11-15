<?php

declare(strict_types=1);

namespace SetCMS\ACL\Exception;

class ACLNotAllowException extends \Exception
{

    /**
     * @var string
     */
    protected $message = 'Для роли "%s" не разрешен доступ к привелегии "%s"';

    public function __construct(string $role, string $privilege)
    {
        parent::__construct(sprintf($this->message, $role, $privilege));
    }
}
