<?php

namespace SetCMS\Module\User\Controller;

use SetCMS\Controller;
use SetCMS\Module\User\Entity\UserEntity;
use SetCMS\Attribute\Http\Parameter\Attributes;

class UserInfoController extends Controller
{

    #[Attributes('currentUser')]
    protected UserEntity $user;
}
