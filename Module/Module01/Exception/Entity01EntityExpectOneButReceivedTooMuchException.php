<?php

declare(strict_types=1);

namespace Module\Module01\Exception;

class Entity01EntityExpectOneButReceivedTooMuchException extends \Exception
{

    /**
     * @var string
     */
    protected $message = 'Ожидалась одна запись, но вернулось больше';
}
