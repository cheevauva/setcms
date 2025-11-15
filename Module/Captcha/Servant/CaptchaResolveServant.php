<?php

declare(strict_types=1);

namespace Module\Captcha\Servant;

use Module\Captcha\CaptchaEntity;

class CaptchaResolveServant extends \UUA\Servant
{

    public string $solvedText;
    public CaptchaEntity $captcha;

    public function serve(): void
    {
        $this->captcha->solve($this->solvedText);
    }
}
