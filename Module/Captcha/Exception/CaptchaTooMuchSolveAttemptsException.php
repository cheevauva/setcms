<?php

declare(strict_types=1);

namespace Module\Captcha\Exception;

class CaptchaTooMuchSolveAttemptsException extends CaptchaException
{

    /**
     * @var string
     */
    protected $message = 'Слишком много попыток, обновите картинку с кодом';
}
