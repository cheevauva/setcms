<?php

declare(strict_types=1);

namespace Module\Email\Exception;

class EmailNotFoundException extends EmailException
{

    use \SetCMS\Exception\ExceptionNotFoundTrait;
}
