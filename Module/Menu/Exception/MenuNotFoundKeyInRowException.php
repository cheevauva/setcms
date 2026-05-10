<?php

declare(strict_types=1);

namespace Module\Menu\Exception;

class MenuMapperNotFoundKeyInRowException extends \Exception
{

    use \SetCMS\Exception\ExceptionEntityMapperNotFoundKeyInRowTrait;
}
