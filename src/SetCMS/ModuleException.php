<?php

namespace SetCMS;

class ModuleException extends \Exception
{

    public static function notFoundModule(string $module): self
    {
        return new static(sprintf('Модуль "%s" не существует', $module));
    }

    public static function notDefinedPrefix(string $module): self
    {
        return new static(sprintf('В модуле "%s" не задан префикс', $module));
    }

    public static function notAllowSectionAction(string $module, string $action, string $section): self
    {
        return new static(sprintf('Действие "%s" в модуле "%s" не может работать в секции "%s"', $action, $module, $section));
    }

    public static function notFoundAction(string $module, string $section, string $action): self
    {
        return new static(sprintf('В модуле "%s" не найдено действие "%s" в секции "%s"', $module, $action, $section));
    }
    
    public static function notAllowActionForThatRequestMethod(string $module, string $section, string $action, string $requestMethod): self
    {
        return new static(sprintf('Недоступны тип запроса "%s" в действии "%s" модуля "%s" секции "%s"', $requestMethod, $action, $module, $section));
    }

    
}
