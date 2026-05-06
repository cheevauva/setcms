<?php

declare(strict_types=1);

namespace Module\Captcha\Exception;

class CaptchaException extends \Exception
{

    /**
     * @var string
     */
    protected $message = 'Исключительная ситуация при обработке каптчи';
}
