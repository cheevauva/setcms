<?php

declare(strict_types=1);

namespace SetCMS\Module\Captcha\Exception;

class CaptchaUnsolvedException extends CaptchaException
{

    protected $message = "Код указан неверно";

}
