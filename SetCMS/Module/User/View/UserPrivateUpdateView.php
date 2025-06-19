<?php

declare(strict_types=1);

namespace SetCMS\Module\User\View;

use SetCMS\Module\User\Entity\UserEntity;

class UserPrivateUpdateView extends \SetCMS\View\ViewJson
{

    public UserEntity $user;
}
