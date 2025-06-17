<?php

declare(strict_types=1);

namespace SetCMS\Module\User\View;

use SetCMS\Module\User\Entity\UserEntity;

class UserPrivateEditView extends \SetCMS\View\ViewTwig
{

    public UserEntity $user;
}
