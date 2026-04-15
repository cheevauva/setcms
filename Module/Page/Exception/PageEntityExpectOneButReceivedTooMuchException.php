<?php

declare(strict_types=1);

namespace Module\Page\Exception;

class PageEntityExpectOneButReceivedTooMuchException extends \Exception
{

    /**
     * @var string
     */
    protected $message = 'Ожидалась одна запись, но вернулось больше';
}
