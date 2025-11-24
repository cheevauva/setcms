<?php

declare(strict_types=1);

namespace Module\Page\Exception;

class PageMapperNotFoundKeyInRowException extends \Exception
{

    /**
     * @var string
     */
    protected $message = 'Не найден ключ %s в массиве row';

    public function __construct(string $key)
    {
        parent::__construct(sprintf($this->message, $key));
    }
}
