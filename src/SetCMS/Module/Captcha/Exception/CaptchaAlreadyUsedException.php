<?php

declare(strict_types=1);

namespace SetCMS\Module\Captcha\Exception;

class CaptchaAlreadyUsedException extends CaptchaException
{

    public function __construct(string $message = 'Код уже использован, обновите картинку')
    {
        parent::__construct($message);
    }
}
