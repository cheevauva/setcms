<?php

declare(strict_types=1);

namespace Module\User\View;

use SetCMS\View\ViewTwig;
use Module\User\Entity\UserEntity;

class UserPublicProfileView extends ViewTwig
{

    public UserEntity $user;
}
