<?php

declare(strict_types=1);

namespace SetCMS\Module\Captcha\Servant;

use SetCMS\Module\Captcha\DAO\CaptchaSaveDAO;

class CaptchaCreateAsPngAndStoreServant extends CaptchaCreateAsPngServant
{

    public function serve(): void
    {
        parent::serve();
    }

}
