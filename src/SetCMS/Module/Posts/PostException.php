<?php

namespace SetCMS\Module\Posts;

class PostException extends \Exception
{

    public static function notFound(): self
    {
        return new static('Запись не найдена');
    }

    public static function badRequest(string $message): self
    {
        return new static('Неверный запрос: ' . $message);
    }
}
