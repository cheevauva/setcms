<?php

declare(strict_types=1);

namespace Module\User\View;

use SetCMS\View\ViewTwig;

class UserPublicRegistrationView extends ViewTwig
{

    protected bool $useCaptcha;

    #[\Override]
    protected function init(): void
    {
        parent::init();

        $this->useCaptcha = boolval($this->env()['CAPTCHA_USE_USER_REGISTRATION'] ?? true);
    }
}
