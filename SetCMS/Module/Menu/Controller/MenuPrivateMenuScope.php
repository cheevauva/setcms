<?php

declare(strict_types=1);

namespace SetCMS\Module\Menu\Controller;

use SetCMS\ControllerViaPSR7;
use SetCMS\Module\Menu\Entity\MenuEntity;
use SetCMS\UUID;

class MenuPrivateMenuScope extends ControllerViaPSR7
{

    public UUID $id;
    public string $label;
    public string $route;
    public string $params;

    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof MenuEntity) {
            $object->id = $this->id;
            $object->label = $this->label;
            $object->params = json_decode($this->params, true);
            $object->route = $this->route;
        }
    }

    #[\Override]
    protected function validate(): \Iterator
    {
        if (!json_validate($this->params)) {
            yield ['params', 'Невалидный json'];
        }

        yield from parent::validate();
    }
}
