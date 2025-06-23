<?php

declare(strict_types=1);

namespace SetCMS\Module\Template\Servant;

use SetCMS\Module\UserResetToken\Entity\UserResetTokenEntity;
use SetCMS\Module\User\Entity\UserEntity;

class TemplateRenderUserResetPasswordServant extends TemplateRenderServant
{

    public UserEntity $user;
    public UserResetTokenEntity $userResetToken;
    //
    protected string $slug = 'resetPassword';
}
