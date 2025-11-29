<?php

declare(strict_types=1);

namespace SetCMS\Exception;

class EntityMapperNotFoundKeyInRowException extends \Exception
{

    /**
     * @var string
     */
    protected $message = 'Не найден ключ %s в массиве row';

    public function __construct(public string $key)
    {
        parent::__construct(sprintf($this->message, $this->key));
    }
}
