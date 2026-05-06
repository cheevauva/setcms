<?php

declare(strict_types=1);

namespace Module\Email\Exception;

class EmailExpectOneButReceivedTooMuchException extends EmailException
{

    use \SetCMS\Exception\ExceptionEntityExpectOneButReceivedTooMuchTrait;
}
