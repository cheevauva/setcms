<?php

declare(strict_types=1);

namespace Module\Module01\Exception;

class Entity01MapperNotFoundKeyInRowException extends \Exception
{

    use \SetCMS\Entity\Exception\EntityMapperNotFoundKeyInRowExceptionTrait;
}
