<?php

declare(strict_types=1);

namespace SetCMS\Module\Captcha\Mediator;

use SetCMS\Module\Captcha\Servant\CaptchaUseResolvedCaptchaServant;
use SetCMS\UUID;

class CaptchaUseResolvedCaptchaMediator extends \UUA\Mediator
{

    public UUID $captcha;

    #[\Override]
    public function serve(): void
    {
        $resolve = CaptchaUseResolvedCaptchaServant::new($this->container);
        $resolve->captcha = $this->captcha;
        $resolve->serve();
    }
}
