<?php

declare(strict_types=1);

namespace Module\Captcha\Servant;

use SetCMS\UUID;
use Module\Captcha\Servant\CaptchaByIdServant;
use Module\Captcha\DAO\CaptchaUpdateDAO;

class CaptchaUseResolvedCaptchaServant extends \UUA\Servant
{

    public UUID $captcha;

    #[\Override]
    public function serve(): void
    {
        $captcha = CaptchaByIdServant::call($this->container, $this->captcha)->captcha;
        $captcha->use();

        CaptchaUpdateDAO::call($this->container, $captcha);
    }
}
