<?php

declare(strict_types=1);

namespace SetCMS\Module\Menu\Controller;

use SetCMS\ControllerViaPSR7;
use SetCMS\Module\Menu\DAO\MenuRetrieveManyDAO;
use SetCMS\Module\Menu\Entity\MenuEntity;

class MenuPrivateIndexController extends ControllerViaPSR7
{

    /**
     * @var MenuEntity[]
     */
    protected array $entities = [];

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            MenuRetrieveManyDAO::class,
        ];
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof MenuRetrieveManyDAO) {
            $this->entities = $object->entities;
        }
    }
}
