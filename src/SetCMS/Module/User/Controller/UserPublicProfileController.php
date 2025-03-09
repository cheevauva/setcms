<?php

namespace SetCMS\Module\User\Controller;

use SetCMS\Controller;
use SetCMS\Module\User\Entity\UserEntity;
use SetCMS\Attribute\Http\Parameter\Attributes;
use SetCMS\Attribute\ResponderPassProperty;
use SetCMS\Attribute\Http\RequestMethod;

#[RequestMethod('GET')]
class UserPublicProfileController extends Controller
{

    #[Attributes('currentUser')]
    #[ResponderPassProperty]
    protected UserEntity $user;
}
