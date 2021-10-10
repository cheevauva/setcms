<?php

namespace SetCMS\Database;

class DatabaseExeption extends \Exception
{

    public static function notFound(string $target): self
    {
        return new self(sprintf('Для "%s" подключение не объявлено', $target));
    }

}
