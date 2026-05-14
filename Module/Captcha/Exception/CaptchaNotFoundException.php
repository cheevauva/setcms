<?php

declare(strict_types=1);

namespace Module\Captcha\Exception;

class CaptchaNotFoundException extends CaptchaException
{

    /**
     * @var string
     * @phpstan-ignore missingType.property
     */
    protected $message = 'Запись не найдена';
}
