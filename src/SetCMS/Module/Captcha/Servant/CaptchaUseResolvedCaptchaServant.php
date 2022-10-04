<?php

declare(strict_types=1);

namespace SetCMS\Module\Captcha\Servant;

use SetCMS\UUID;
use SetCMS\Module\Captcha\DAO\CaptchaEntityDbRetrieveByIdDAO;
use SetCMS\Module\Captcha\DAO\CaptchaEntityDbSaveDAO;

class CaptchaUseResolvedCaptchaServant implements \SetCMS\ServantInterface
{

    use \SetCMS\DITrait;
    use \SetCMS\FactoryTrait;

    public UUID $captcha;

    public function serve(): void
    {
        $captchaRetrieveeById = CaptchaEntityDbRetrieveByIdDAO::make($this->factory());
        $captchaRetrieveeById->id = $this->captcha;
        $captchaRetrieveeById->serve();

        if (!$captchaRetrieveeById->captcha) {
            throw new \Excepton('Не найдена каптча для распознания');
        }

        $captcha = $captchaRetrieveeById->captcha;
        $captcha->use();

        $captchaSave = CaptchaEntityDbSaveDAO::make($this->factory());
        $captchaSave->entity = $captcha;
        $captchaSave->serve();
    }

}
