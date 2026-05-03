<?php

declare(strict_types=1);

namespace Module\Captcha\Exception;

class CaptchasNotFoundException extends CaptchaException
{

    /**
     * @var string
     */
    protected $message = 'Записи не найдены';
}
