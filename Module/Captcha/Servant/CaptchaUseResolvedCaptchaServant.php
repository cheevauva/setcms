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
    protected function run(): void
    {
        $captcha = CaptchaByIdServant::call($this, $this->captcha)->entity;
        $captcha->use();

        CaptchaUpdateDAO::call($this, $captcha);
    }
}
