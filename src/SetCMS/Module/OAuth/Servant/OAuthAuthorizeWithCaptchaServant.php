<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\Servant;

use SetCMS\Module\OAuth\Servant\OAuthAuthorizeServant;
use SetCMS\Module\Captcha\Servant\CaptchaUseResolvedCaptchaServant;
use SetCMS\UUID;

class OAuthAuthorizeWithCaptchaServant extends OAuthAuthorizeServant
{

    public UUID $captcha;

    public function serve(): void
    {
//        $useCaptcha = CaptchaUseResolvedCaptchaServant::make($this->factory());
//        $useCaptcha->captcha = $this->captcha;
//        $useCaptcha->serve();

        parent::serve();
    }

}
