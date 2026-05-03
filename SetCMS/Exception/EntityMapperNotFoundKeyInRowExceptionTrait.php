<?php

declare(strict_types=1);

namespace SetCMS\Exception;

trait EntityMapperNotFoundKeyInRowExceptionTrait
{

    public function __construct(public string $key)
    {
        parent::__construct(sprintf('Не найден ключ %s в массиве row', $this->key));
    }
}
