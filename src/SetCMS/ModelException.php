<?php

namespace SetCMS;

use SetCMS\HttpStatusCode\BadRequest;

class ModelException extends \Exception
{

    public static function badRequest(string $message): self
    {
        return new class($message) extends ModelException implements BadRequest {
            
        };
    }

    public static function invalidField(string $field): self
    {
        return static::badRequest(sprintf('Поле "%s" имеет неверный формат', $field));
    }

    public static function convertFail(string $type): self
    {
        return static::badRequest(sprintf('Не смог привести значение к типу "%s"', $type));
    }

}
