<?php

namespace SetCMS\Module\Captcha;

class CaptchaException extends \Exception
{

    public static function alreadyExpired(): self
    {
        return new static('Картинка и код для неё уже не действительны');
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
