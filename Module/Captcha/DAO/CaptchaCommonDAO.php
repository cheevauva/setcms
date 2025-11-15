<?php

declare(strict_types=1);

namespace Module\Captcha\DAO;

use Module\Captcha\Mapper\CaptchaEntityMapper;
use Module\Captcha\CaptchaConstants;

trait CaptchaCommonDAO
{

    use \SetCMS\Traits\DatabaseMainTrait;

    protected function table(): string
    {
        return CaptchaConstants::TABLE_NAME;
    }

    protected function mapper(): CaptchaEntityMapper
    {
        return CaptchaEntityMapper::new($this->container);
    }
}
