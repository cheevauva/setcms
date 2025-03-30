<?php

declare(strict_types=1);

namespace SetCMS\Module\User\View;

use SetCMS\View\ViewTwig;
use SetCMS\Module\User\Entity\UserEntity;

class UserPublicProfileView extends ViewTwig
{

    public UserEntity $user;
}
