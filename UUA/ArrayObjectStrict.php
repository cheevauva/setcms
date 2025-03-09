<?php

declare(strict_types=1);

namespace UUA;

class ArrayObjectStrict extends \ArrayObject
{

    #[\Override]
    public function offsetGet(mixed $key): mixed
    {
        if (!parent::offsetExists($key)) {
            throw new \RuntimeException(sprintf('Ключ %s не найден в массиве', $key));
        }

        return parent::offsetGet($key);
    }
}
