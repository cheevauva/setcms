<?php

declare(strict_types=1);

namespace Module\User\View;

use Module\User\Entity\UserEntity;

class UserPrivateIndexView extends \SetCMS\View\ViewTwig
{

    /**
     * @var UserEntity[]
     */
    public array $users;
}
