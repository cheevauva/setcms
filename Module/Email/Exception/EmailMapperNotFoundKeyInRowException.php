<?php

declare(strict_types=1);

namespace Module\Email\Exception;

class EmailMapperNotFoundKeyInRowException extends \Exception
{

    use \SetCMS\Exception\ExceptionEntityMapperNotFoundKeyInRowTrait;
}
