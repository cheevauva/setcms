<?php

declare(strict_types=1);

namespace Module\Email\Exception;

class EmailsNotFoundException extends EmailException
{

    use \SetCMS\Exception\ExceptionEntitiesNotFoundTrait;
}
