<?php

declare(strict_types=1);

namespace Module\Captcha\DAO;

use Module\Captcha\CaptchaEntity;

class CaptchaSaveDAO extends \SetCMS\DAO\EntitySaveDAO
{

    use CaptchaCommonDAO;

    public CaptchaEntity $captcha;

    public function serve(): void
    {
        $this->entity = $this->captcha;

        parent::serve();
    }
}
