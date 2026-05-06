<?php

declare(strict_types=1);

namespace Module\Captcha\Exception;

class CaptchaExpectOneButReceivedTooMuchException extends CaptchaException
{

    use \SetCMS\Exception\ExceptionEntityExpectOneButReceivedTooMuchTrait;
}
