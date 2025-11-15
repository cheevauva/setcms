<?php

declare(strict_types=1);

namespace Module\User\View;

use Module\User\Entity\UserEntity;

class UserPrivateUpdateView extends \SetCMS\View\ViewJson
{

    public UserEntity $user;
}
