<?php

declare(strict_types=1);

namespace SetCMS\Module\Captcha\Servant;

use SetCMS\UUID;
use SetCMS\Module\Captcha\CaptchaEntity;
use SetCMS\Module\Captcha\DAO\CaptchaRetrieveManyByCriteriaDAO;
use SetCMS\Module\Captcha\DAO\CaptchaSaveDAO;

class CaptchaUseResolvedCaptchaServant extends \UUA\Servant
{

    public UUID $captcha;

    #[\Override]
    public function serve(): void
    {
        $captchaById = CaptchaRetrieveManyByCriteriaDAO::new($this->container);
        $captchaById->id = $this->captcha;
        $captchaById->orThrow = true;
        $captchaById->serve();

        $captcha = CaptchaEntity::as($captchaById->first);
        $captcha->use();

        $captchaSave = CaptchaSaveDAO::new($this->container);
        $captchaSave->captcha = $captcha;
        $captchaSave->serve();
    }
}
