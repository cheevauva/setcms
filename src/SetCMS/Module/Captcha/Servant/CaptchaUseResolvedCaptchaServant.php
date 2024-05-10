<?php

declare(strict_types=1);

namespace SetCMS\Module\Captcha\Servant;

use SetCMS\UUID;
use SetCMS\Module\Captcha\DAO\CaptchaRetrieveByIdDAO;
use SetCMS\Module\Captcha\DAO\CaptchaSaveDAO;

class CaptchaUseResolvedCaptchaServant implements \SetCMS\Contract\Servant
{

    use \SetCMS\DITrait;
    use \SetCMS\FactoryTrait;

    public UUID $captcha;

    public function serve(): void
    {
        $captchaRetrieveById = CaptchaRetrieveByIdDAO::make($this->factory());
        $captchaRetrieveById->id = $this->captcha;
        $captchaRetrieveById->serve();

        if (!$captchaRetrieveById->captcha) {
            throw new \Excepton('Не найдена каптча для распознания');
        }

        $captcha = $captchaRetrieveById->captcha;
        $captcha->use();

        $captchaSave = CaptchaSaveDAO::make($this->factory());
        $captchaSave->captcha = $captcha;
        $captchaSave->serve();
    }

}
