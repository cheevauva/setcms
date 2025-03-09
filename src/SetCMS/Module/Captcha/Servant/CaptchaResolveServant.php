<?php

declare(strict_types=1);

namespace SetCMS\Module\Captcha\Servant;

use SetCMS\Module\Captcha\CaptchaEntity;

class CaptchaResolveServant extends \UUA\Servant
{

    public string $solvedText;
    public CaptchaEntity $captcha;

    public function serve(): void
    {
        $this->captcha->solve($this->solvedText);
    }

}
