<?php

declare(strict_types=1);

namespace SetCMS\Module\Captcha\Exception;

class CaptchaAlreadySolvedException extends CaptchaException
{

    protected $message = "Вы уже указали правильный код";

}
