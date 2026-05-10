<?php

declare(strict_types=1);

namespace Module\Menu\Exception;

class MenuExpectOneButReceivedTooMuchException extends MenuException
{

    use \SetCMS\Exception\ExceptionEntityExpectOneButReceivedTooMuchTrait;
}
