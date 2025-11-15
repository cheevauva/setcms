<?php

declare(strict_types=1);

namespace Module\Captcha\Controller;

use SetCMS\ControllerViaPSR7;
use Module\Captcha\CaptchaEntity;
use Module\Captcha\DAO\CaptchaSaveDAO;
use Module\Captcha\View\CaptchaPublicGenerateView;

class CaptchaPublicGenerateController extends ControllerViaPSR7
{

    protected CaptchaEntity $captcha;

    #[\Override]
    protected function init(): void
    {
        parent::init();

        $this->captcha = new CaptchaEntity();
    }

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            CaptchaSaveDAO::class,
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            CaptchaPublicGenerateView::class,
        ];
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof CaptchaSaveDAO) {
            $object->captcha = $this->captcha;
        }

        if ($object instanceof CaptchaPublicGenerateView) {
            $object->captcha = $this->captcha;
            $object->includeLines = boolval($this->env()['CAPTCHA_GENERATE_LINES'] ?? true);
            $object->includePixels = boolval($this->env()['CAPTCHA_GENERATE_PIXELS'] ?? true);
        }
    }
}
