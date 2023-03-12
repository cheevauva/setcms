<?php

declare(strict_types=1);

namespace SetCMS\Module\Block;

use SetCMS\Entity;

class BlockEntity extends Entity
{

    use \SetCMS\AsTrait;

    public string $path;
    public array $params;
    public ?string $template = null;
    public ?string $section = null;

}
