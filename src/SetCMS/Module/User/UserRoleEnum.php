<?php

declare(strict_types=1);

namespace SetCMS\Module\User;

enum UserRoleEnum: string
{

    case GUEST = 'guest';
    case USER = 'user';
    case ADMIN = 'admin';
    
}
