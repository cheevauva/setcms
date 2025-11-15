<?php

declare(strict_types=1);

namespace Module\Menu\MenuAction\Entity;

class MenuActionEntity extends \SetCMS\Entity\Entity
{

    public string $label;
    public string $route;

    /**
     * @var array<string, mixed>
     */
    public array $params = [];
}
