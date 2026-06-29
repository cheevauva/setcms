<?php

declare(strict_types=1);

namespace Module\Menu\Mapper;

use Module\Menu\Entity\MenuEntity;

class MenuFromRequestMapper extends \SetCMS\Request\Mapper\RequestMapper
{

    public protected(set) MenuEntity $menu;

    #[\Override]
    public function serve(): void
    {
        $body = $this->validationBody();
        $body->array('menu')->notEmpty()->validate();

        $this->menu = new MenuEntity();
        $this->menu->id = $body->uuid('menu.id')->val();
        $this->menu->label = $body->string('menu.label')->notEmpty()->val();
        $this->menu->route = $body->string('menu.route')->notEmpty()->val();
        $this->menu->params = $body->json('menu.params')->notEmpty()->asArray()->val();
    }
}
