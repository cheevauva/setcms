<?php

declare(strict_types=1);

namespace Module\Captcha\Exception;

class CaptchaExpectOneButReceivedTooMuchException extends CaptchaException
{
    /**
     * @var string
     */
    protected $message = 'Ожидалась одна запись, но вернулось больше';
}
