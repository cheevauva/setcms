<?php

namespace SetCMS;

use SetCMS\HttpStatusCode\NotFound;
use SetCMS\HttpStatusCode\Forbidden;
use SetCMS\HttpStatusCode\BadRequest;
use SetCMS\HttpStatusCode\InternalServerError;

class ModuleException extends \Exception
{

    public static function serverError(string $message): self
    {
        return new class($message) extends ModuleException implements InternalServerError {
            
        };
    }

    public static function badRequest(string $message): self
    {
        return new class($message) extends ModuleException implements BadRequest {
            
        };
    }

    public static function notFound(string $message = 'На найден указанный ресурс'): self
    {
        return new class($message) extends ModuleException implements NotFound {
            
        };
    }

    public static function notAllow(string $message = 'Доступ запрещен'): self
    {
        return new class($message) extends ModuleException implements Forbidden {
            
        };
    }

    public static function notFoundModule(string $module): self
    {
        return self::notFound(sprintf('Модуль "%s" не существует', $module));
    }

    public static function notDefinedPrefix(string $module): self
    {
        return self::serverError(sprintf('В модуле "%s" не задан префикс', $module));
    }

    public static function notAllowSectionAction(string $module, string $action, string $section): self
    {
        return self::notAllow(sprintf('Действие "%s" в модуле "%s" не может работать в секции "%s"', $action, $module, $section));
    }

    public static function notFoundAction(string $module, string $section, string $action): self
    {
        return self::serverError(sprintf('В модуле "%s" не найдено действие "%s" в секции "%s"', $module, $action, $section));
    }

    public static function notAllowActionForThatRequestMethod(string $module, string $section, string $action, string $requestMethod): self
    {
        return self::badRequest(sprintf('Недоступны тип запроса "%s" в действии "%s" модуля "%s" секции "%s"', $requestMethod, $action, $module, $section));
    }

}
