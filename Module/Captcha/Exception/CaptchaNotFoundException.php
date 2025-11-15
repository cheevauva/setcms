<?php

declare(strict_types=1);

namespace Module\Captcha\Exception;

class CaptchaNotFoundException extends CaptchaException
{

    public function __construct(string $message = 'Каптча не найдена')
    {
        parent::__construct($message);
    }
}
