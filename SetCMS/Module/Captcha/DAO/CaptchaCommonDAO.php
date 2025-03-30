<?php

declare(strict_types=1);

namespace SetCMS\Module\Captcha\DAO;

use SetCMS\Module\Captcha\Mapper\CaptchaEntityMapper;
use SetCMS\Module\Captcha\CaptchaConstants;

trait CaptchaCommonDAO
{

    use \SetCMS\Traits\DatabaseMainConnectionTrait;

    protected function table(): string
    {
        return CaptchaConstants::TABLE_NAME;
    }

    protected function mapper(): CaptchaEntityMapper
    {
        return CaptchaEntityMapper::new($this->container);
    }
}
