<?php

declare(strict_types=1);

namespace SetCMS\Module\Captcha\Exception;

class CaptchaTooMuchSolveAttemptsException extends CaptchaException
{

    protected $message = "Слишком много попыток, обновите картинку с кодом";

}
