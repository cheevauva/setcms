<?php

namespace SetCMS\Module\Posts;

class PostException extends \Exception
{

    public static function notFound(): self
    {
        return new class('Запись не найдена')  extends PostException implements \SetCMS\HttpStatusCode\NotFound {
            
        };
    }

    public static function badRequest(string $message): self
    {
        return new static('Неверный запрос: ' . $message);
    }

}
