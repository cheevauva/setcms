<?php

declare(strict_types=1);

namespace Module\Menu\DAO;

use SetCMS\DAO\EntityRetrieveByIdDAO;
use Module\Menu\Entity\MenuEntity;
use Module\Menu\Exception\MenuNotFoundException;

class MenuRetrieveManyByCriteriaDAO extends EntityRetrieveByIdDAO
{

    use MenuCommonDAO;

    /**
     * @var MenuEntity[]
     */
    public array $menus;
    public ?MenuEntity $menu;

    #[\Override]
    public function serve(): void
    {
        parent::serve();

        $this->menu = $this->first ? MenuEntity::as($this->first) : null;
        $this->menus = MenuEntity::manyAs($this->entities);
    }

    #[\Override]
    protected function notFoundExcecption(): \Throwable
    {
        return new MenuNotFoundException();
    }
}
