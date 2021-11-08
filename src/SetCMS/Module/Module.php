<?php

namespace SetCMS\Module;

use SetCMS\Module\Modules\Contract\ModuleAdminInterface;
use SetCMS\Module\Modules\Contract\ModuleIndexInterface;
use SetCMS\Module\Modules\Contract\ModuleResourceInterface;

abstract class Module
{

    public const SECTION_ADMIN = 'Admin';
    public const SECTION_INDEX = 'Index';
    public const SECTION_RESOURCE = 'Resource';

    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDefaultAction(): string
    {
        return 'index';
    }

    public function getDefaultSection(): string
    {
        return static::SECTION_INDEX;
    }

    public function getSectionClassName(string $section): string
    {
        $object = $this;

        switch ($section) {
            case static::SECTION_ADMIN:
                if ($object instanceof ModuleAdminInterface) {
                    return $object->getAdminControllerClassName();
                }
                break;
            case static::SECTION_INDEX:
                if ($object instanceof ModuleIndexInterface) {
                    return $object->getIndexControllerClassName();
                }
                break;
            case static::SECTION_RESOURCE:
                if ($object instanceof ModuleResourceInterface) {
                    return $object->getResourceControllerClassName();
                }
                break;
        }

        throw ModuleException::notAllowSection($this->name, $section);
    }

}
