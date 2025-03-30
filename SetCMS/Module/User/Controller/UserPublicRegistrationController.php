<?php

namespace SetCMS\Module\User\Controller;

use SetCMS\Module\User\View\UserPublicRegistrationView;

class UserPublicRegistrationController extends \SetCMS\Controller
{

    protected bool $useCaptcha;

    #[\Override]
    protected function init(): void
    {
        parent::init();

        $this->useCaptcha = boolval($this->env()['CAPTCHA_USE_USER_REGISTRATION'] ?? true);
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            UserPublicRegistrationView::class
        ];
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof UserPublicRegistrationView) {
            $object->useCaptcha = $this->useCaptcha;
        }
    }
}
