<?php

declare(strict_types=1);

namespace Module\Captcha\Exception;

class CaptchaMapperNotFoundKeyInRowException extends \Exception
{

    use \SetCMS\Exception\EntityMapperNotFoundKeyInRowExceptionTrait;
}
