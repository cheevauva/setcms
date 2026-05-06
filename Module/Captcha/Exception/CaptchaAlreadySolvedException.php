<?php

declare(strict_types=1);

namespace Module\Captcha\Exception;

class CaptchaAlreadySolvedException extends CaptchaException
{

    /**
     * @var string
     */
    protected $message = 'Вы уже указали правильный код';
}
