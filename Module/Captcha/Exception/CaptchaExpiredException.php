<?php

declare(strict_types=1);

namespace Module\Captcha\Exception;

class CaptchaExpiredException extends CaptchaException
{

    /**
     * @var string
     */
    protected $message = 'Картинка и код для неё уже не действительны';
}
