<?php

namespace SetCMS;

use SetCMS\HttpStatusCode\NotFound;

class ModuleException extends \Exception
{

    public static function notFound(string $message): self
    {
        return new class($message) extends ModuleException implements NotFound {
            
        };
    }

    public static function notFoundModule(string $module): self
    {
        return self::notFound(sprintf('Модуль "%s" не существует', $module));
    }

    public static function notDefinedPrefix(string $module): self
    {
        return self::notFound(sprintf('В модуле "%s" не задан префикс', $module));
    }

    public static function notAllowSectionAction(string $module, string $action, string $section): self
    {
        return self::notFound(sprintf('Действие "%s" в модуле "%s" не может работать в секции "%s"', $action, $module, $section));
    }

    public static function notFoundAction(string $module, string $section, string $action): self
    {
        return self::notFound(sprintf('В модуле "%s" не найдено действие "%s" в секции "%s"', $module, $action, $section));
    }

    public static function notAllowActionForThatRequestMethod(string $module, string $section, string $action, string $requestMethod): self
    {
        return self::notFound(sprintf('Недоступны тип запроса "%s" в действии "%s" модуля "%s" секции "%s"', $requestMethod, $action, $module, $section));
    }

}
