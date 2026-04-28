<?php

declare(strict_types=1);

namespace Module\Captcha\Traits;

use Module\Captcha\CaptchaConstants;

trait CaptchaDbalDAOTrait
{

    use \SetCMS\Traits\TraitsDatabaseMain;

    protected function table(): string
    {
        return CaptchaConstants::TABLE_NAME;
    }
}
