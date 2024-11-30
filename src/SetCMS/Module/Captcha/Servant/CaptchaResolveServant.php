<?php

declare(strict_types=1);

namespace SetCMS\Module\Captcha\Servant;

use SetCMS\Module\Captcha\CaptchaEntity;

class CaptchaResolveServant implements \SetCMS\Contract\Servant
{

    use \SetCMS\Traits\DITrait;
    use \SetCMS\Traits\FactoryTrait;

    public string $solvedText;
    public CaptchaEntity $captcha;

    public function serve(): void
    {
        $this->captcha->solve($this->solvedText);
    }

}
