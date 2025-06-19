<?php

declare(strict_types=1);

namespace SetCMS\Module\Captcha\Exception;

class CaptchaExpiredException extends CaptchaException
{

    public function __construct(string $message = 'Картинка и код для неё уже не действительны')
    {
        parent::__construct($message);
    }
}
