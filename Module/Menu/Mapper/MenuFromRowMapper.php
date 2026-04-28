<?php

declare(strict_types=1);

namespace Module\Menu\Mapper;

use Module\Menu\Entity\MenuEntity;

class MenuFromRowMapper extends \UUA\Mapper
{

    use \SetCMS\Mapper\MapperEntityFromRowTrait;

    public protected(set) MenuEntity $menu;

    #[\Override]
    public function serve(): void
    {
        $this->menu = new MenuEntity();
        $this->menu->label = $this->string('label');
        $this->menu->route = $this->string('route');
        $this->menu->params = $this->json('params');
        $this->mappingDefault($this->menu);
    }

    #[\Override]
    protected function notFoundKeyInRowException(string $key): \Throwable
    {
        return new \Exception($key);
    }
}
