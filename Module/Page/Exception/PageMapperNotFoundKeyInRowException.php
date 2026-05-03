<?php

declare(strict_types=1);

namespace Module\Page\Exception;

class PageMapperNotFoundKeyInRowException extends \Exception
{

    use \SetCMS\Exception\EntityMapperNotFoundKeyInRowExceptionTrait;
}
