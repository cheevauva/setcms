<?php

declare(strict_types=1);

namespace Module\Captcha\Exception;

class CaptchaUnsolvedException extends CaptchaException
{

    /**
     * @var string
     */
    protected $message = 'Код указан неверно';
}
