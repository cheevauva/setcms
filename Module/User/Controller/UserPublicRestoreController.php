<?php

declare(strict_types=1);

namespace Module\User\Controller;

use SetCMS\Controller\ControllerViaPSR7;
use Module\User\View\UserPublicRestoreView;

class UserPublicRestoreController extends ControllerViaPSR7
{

    protected bool $useCaptcha;

    #[\Override]
    protected function init(): void
    {
        parent::init();

        $this->useCaptcha = boolval($this->env()['CAPTCHA_USE_USER_RESTORE'] ?? true);
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            UserPublicRestoreView::class,
        ];
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof UserPublicRestoreView) {
            $object->useCaptcha = $this->useCaptcha;
        }
    }
}
