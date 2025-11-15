<?php

declare(strict_types=1);

namespace Module\Captcha\Exception;

class CaptchaException extends \Exception
{

    public function __construct(string $message = 'Исключительная ситуация при обработке каптчи')
    {
        parent::__construct($message);
    }
}
