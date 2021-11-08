<?php

namespace SetCMS\Module\Modules\Contract;

interface ModuleResourceInterface
{

    public function getEntityClassName(): string;

    public function getResourceControllerClassName(): string;

    public function getResource(): string;
}
