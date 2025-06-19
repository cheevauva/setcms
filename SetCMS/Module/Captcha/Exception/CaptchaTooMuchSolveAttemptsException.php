<?php

declare(strict_types=1);

namespace SetCMS\Module\Captcha\Exception;

class CaptchaTooMuchSolveAttemptsException extends CaptchaException
{

    public function __construct(string $message = 'Слишком много попыток, обновите картинку с кодом')
    {
        parent::__construct($message);
    }
}
