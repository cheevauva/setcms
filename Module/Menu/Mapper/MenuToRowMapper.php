<?php

declare(strict_types=1);

namespace Module\Menu\Mapper;

class MenuToRowMapper extends \SetCMS\Entity\Mapper\EntityToRowMapper
{

    use \Module\Menu\Traits\MenuCallTrait;

    #[\Override]
    public function serve(): void
    {
        $this->id($this->menu);
        $this->row['label'] = $this->menu->label;
        $this->row['route'] = $this->menu->route;
        $this->row['params'] = $this->json($this->menu->params);
    }
}
