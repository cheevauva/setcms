<?php

declare(strict_types=1);

namespace SetCMS\Module\Captcha\Exception;

class CaptchaAlreadyUsedException extends CaptchaException
{

    protected $message = "Код уже использован, обновите картинку";

}
