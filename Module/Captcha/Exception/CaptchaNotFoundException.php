<?php

declare(strict_types=1);

namespace Module\Captcha\Exception;

class CaptchaNotFoundException extends CaptchaException
{

    use \SetCMS\Exception\ExceptionNotFoundTrait;
}
