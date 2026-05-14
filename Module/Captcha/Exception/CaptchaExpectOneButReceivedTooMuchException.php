<?php

declare(strict_types=1);

namespace Module\Captcha\Exception;

class CaptchaExpectOneButReceivedTooMuchException extends CaptchaException
{

    /**
     * @var string
     * @phpstan-ignore missingType.property
     */
    protected $message = 'Ожидалась одна запись, но вернулось больше';
}
