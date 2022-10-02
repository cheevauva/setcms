<?php

declare(strict_types=1);

namespace SetCMS\Module\Captcha\Servant;

use SetCMS\Module\Captcha\DAO\CaptchaEntityDbSaveDAO;

class CaptchaCreateAsPngAndStoreServant extends CaptchaCreateAsPngServant
{

    public function serve(): void
    {
        parent::serve();

        $saveCaptcha = CaptchaEntityDbSaveDAO::factory($this->factory);
        $saveCaptcha->entity = $this->captcha;
        $saveCaptcha->serve();
    }

}
