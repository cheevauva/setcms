<?php

declare(strict_types=1);

namespace Module\Template\Servant;

use Module\UserResetToken\Entity\UserResetTokenEntity;
use Module\User\Entity\UserEntity;

class TemplateRenderUserResetPasswordServant extends TemplateRenderServant
{

    public UserEntity $user;
    public UserResetTokenEntity $userResetToken;
    //
    protected string $slug = 'resetPassword';
}
