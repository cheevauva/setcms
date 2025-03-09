<?php

declare(strict_types=1);

namespace SetCMS\Module\Captcha\Exception;

class CaptchaUnsolvedException extends CaptchaException
{

    public function __construct(string $message = 'Код указан неверно')
    {
        parent::__construct($message);
    }

}
