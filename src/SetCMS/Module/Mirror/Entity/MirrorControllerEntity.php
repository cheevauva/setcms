<?php

declare(strict_types=1);

namespace SetCMS\Module\Mirror\Entity;

class MirrorControllerEntity
{

    use \SetCMS\Traits\AsTrait;

    public bool $isPublic = false;
    public bool $isPrivate = false;
    public string $module;
    public string $filename;
    public string $className;
}
