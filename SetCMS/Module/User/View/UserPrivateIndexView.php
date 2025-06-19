<?php

declare(strict_types=1);

namespace SetCMS\Module\User\View;

use SetCMS\Module\User\Entity\UserEntity;

class UserPrivateIndexView extends \SetCMS\View\ViewTwig
{

    /**
     * @var UserEntity[]
     */
    public array $users;
}
