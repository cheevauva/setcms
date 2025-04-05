<?php

declare(strict_types=1);

namespace SetCMS\Module\User\Controller;

use SetCMS\ControllerViaPSR7;
use SetCMS\Module\User\View\UserPublicLoginView;

class UserPublicLoginController extends ControllerViaPSR7
{

    protected bool $useCaptcha;

    #[\Override]
    protected function init(): void
    {
        parent::init();

        $this->useCaptcha = boolval($this->env()['CAPTCHA_USE_USER_LOGIN'] ?? true);
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            UserPublicLoginView::class
        ];
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof UserPublicLoginView) {
            $object->useCaptcha = $this->useCaptcha;
        }
    }
}
