<?php

declare(strict_types=1);

namespace Module\Menu\Mapper;

use Module\Menu\Entity\MenuEntity;
use Module\Menu\Exception\MenuMapperNotFoundKeyInRowException;

class MenuFromRowMapper extends \SetCMS\Entity\Mapper\EntityFromRowMapper
{

    public protected(set) MenuEntity $menu;

    #[\Override]
    public function serve(): void
    {
        $this->menu = new MenuEntity();
        $this->menu->id = $this->uuid('id');
        $this->menu->label = $this->string('label');
        $this->menu->route = $this->string('route');
        $this->menu->params = $this->json('params');
        $this->id($this->menu);
    }

    #[\Override]
    protected function notFoundKeyInRowException(string $key): MenuMapperNotFoundKeyInRowException
    {
        return new MenuMapperNotFoundKeyInRowException($key);
    }
}
