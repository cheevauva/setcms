<?php

declare(strict_types=1);

namespace SetCMS\Module\Menu\DAO;

use SetCMS\Common\DAO\EntityRetrieveByIdDAO;
use SetCMS\Module\Menu\Entity\MenuEntity;
use SetCMS\Module\Menu\Exception\MenuNotFoundException;

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
