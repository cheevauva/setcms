<?php

declare(strict_types=1);

namespace SetCMS\Module\Block;

use SetCMS\Common\Entity\Entity;

class BlockEntity extends Entity
{

    

    public string $path;
    public array $params;
    public ?string $template = null;
    public ?string $section = null;

}
