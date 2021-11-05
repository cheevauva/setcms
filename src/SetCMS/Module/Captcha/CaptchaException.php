<?php

namespace SetCMS\Module\Captcha;

use SetCMS\HttpStatusCode\NotFound;

class CaptchaException extends \Exception
{

    public static function notFound($message = 'Капта не найдена')
    {
        return new class($message) extends CaptchaException implements NotFound {
            
        };
    }

    public static function alreadyExpired(): self
    {
        return new static('Картинка и код для неё уже не действительны');
    }

    public static function alreadyUsed(): self
    {
        return new static('Код уже использован, обновите картинку');
    }

    public static function unsolved(): self
    {
        return new static('Код указан неверно');
    }

    public static function alreadySolved(): self
    {
        return new static('Вы уже указали правильный код');
    }

    public static function tooMuchSolveAttempts(): self
    {
        return new static('Слишком много попыток, обновите картинку с кодом');
    }

}
