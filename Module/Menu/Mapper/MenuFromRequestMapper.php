<?php

declare(strict_types=1);

namespace Module\Menu\Mapper;

use Module\Menu\Entity\MenuEntity;

class MenuFromRequestMapper extends \SetCMS\Request\Mapper\RequestMapper
{

    public protected(set) MenuEntity $entity;

    #[\Override]
    protected function run(): void
    {
        $body = $this->validationBody();
        $body->array('menu')->notEmpty()->validate();

        $this->entity = new MenuEntity();
        $this->entity->id = $body->uuid('menu.id')->val();
        $this->entity->label = $body->string('menu.label')->notEmpty()->val();
        $this->entity->route = $body->string('menu.route')->notEmpty()->val();
        $this->entity->params = $body->json('menu.params')->notEmpty()->asArray()->val();
    }
}
