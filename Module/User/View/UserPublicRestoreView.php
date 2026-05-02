<?php

declare(strict_types=1);

namespace Module\User\View;

class UserPublicRestoreView extends \SetCMS\View\ViewTwig
{

    protected bool $useCaptcha;

    #[\Override]
    protected function init(): void
    {
        parent::init();

        $this->useCaptcha = boolval($this->env()['CAPTCHA_USE_USER_RESTORE'] ?? true);
    }
}
