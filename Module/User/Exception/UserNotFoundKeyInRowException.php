<?php

declare(strict_types=1);

namespace Module\User\Exception;

class UserNotFoundKeyInRowException extends \Exception
{

    use \SetCMS\Exception\EntityMapperNotFoundKeyInRowExceptionTrait;
}
