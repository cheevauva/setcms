<?php

declare(strict_types=1);

namespace SetCMS\Module\Captcha\Exception;

class CaptchaAlreadySolvedException extends CaptchaException
{

    public function __construct(string $message = 'Вы уже указали правильный код')
    {
        parent::__construct($message);
    }
}
