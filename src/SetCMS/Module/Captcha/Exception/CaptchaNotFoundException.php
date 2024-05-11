<?php

declare(strict_types=1);

namespace SetCMS\Module\Captcha\Exception;

class CaptchaNotFoundException extends CaptchaException
{

    protected $message = "Каптча не найдена";

}
