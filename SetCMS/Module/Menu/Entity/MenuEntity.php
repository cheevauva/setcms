<?php

declare(strict_types=1);

namespace SetCMS\Module\Menu\Entity;

use SetCMS\Common\Entity\Entity;

class MenuEntity extends Entity
{

    public string $label;
    public string $route;
    /**
     * @var array<string|int, mixed>
     */
    public array $params = [];
}
