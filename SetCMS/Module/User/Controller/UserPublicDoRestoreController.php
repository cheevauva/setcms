<?php

declare(strict_types=1);

namespace SetCMS\Module\User\Controller;

use SetCMS\UUID;
use SetCMS\Module\Captcha\Servant\CaptchaUseResolvedCaptchaServant;
use SetCMS\Module\User\View\UserPublicDoRestoreView;
use SetCMS\ControllerViaPSR7;
use SetCMS\Module\Captcha\Exception\CaptchaException;

class UserPublicDoRestoreController extends ControllerViaPSR7
{

    protected bool $useCaptcha = false;
    public string $email;
    public UUID $captcha;

    #[\Override]
    protected function init(): void
    {
        parent::init();

        $this->useCaptcha = boolval($this->env()['CAPTCHA_USE_USER_RESTORE'] ?? true);
    }

    #[\Override]
    protected function domainUnits(): array
    {
        return array_filter([
            $this->useCaptcha ? CaptchaUseResolvedCaptchaServant::class : null,
        ]);
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            UserPublicDoRestoreView::class,
        ];
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof CaptchaUseResolvedCaptchaServant) {
            $object->captcha = $this->captcha;
        }
    }

    #[\Override]
    protected function process(): void
    {
        $validation = $this->validation($this->request->getParsedBody());

        $this->email = $validation->string('email')->notEmpty()->val();

        if ($this->useCaptcha) {
            $this->captcha = $validation->uuid('captcha')->notEmpty()->val();
        }
    }

    #[\Override]
    protected function catch(\Throwable $object): void
    {
        parent::catch($object);
        
        if ($object instanceof CaptchaException) {
            $this->messages->attach($object, 'captcha');
        }
    }
}
