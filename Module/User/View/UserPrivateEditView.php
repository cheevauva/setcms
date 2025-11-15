<?php

declare(strict_types=1);

namespace Module\User\View;

use Module\User\Entity\UserEntity;

class UserPrivateEditView extends \SetCMS\View\ViewTwig
{

    public UserEntity $user;
}
