<?php

declare(strict_types=1);

namespace SetCMS\Module\User\Exception;

use SetCMS\Module\User\UserEntity;
use SetCMS\Exception;

class UserException extends Exception
{

    public ?UserEntity $user = null;

    public function label(): string
    {
        return 'setcms.user.label';
    }

    public static function withoutUser(): self
    {
        return new static(get_called_class());
    }

    public static function notFound(): self
    {
        return new static('Пользователь не найден');
    }

    public static function withUser(UserEntity $user): self
    {
        $self = new static(get_called_class());
        $self->user = $user;

        return $self;
    }

}
