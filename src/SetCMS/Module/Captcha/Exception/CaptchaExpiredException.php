<?php

declare(strict_types=1);

namespace SetCMS\Module\Captcha\Exception;

class CaptchaExpiredException extends CaptchaException
{

    protected $message = "Картинка и код для неё уже не действительны";

}
