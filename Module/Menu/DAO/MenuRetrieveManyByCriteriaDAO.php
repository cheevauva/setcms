<?php

declare(strict_types=1);

namespace Module\Menu\DAO;

use Module\Menu\Entity\MenuEntity;
use Module\Menu\Exception\MenuNotFoundException;
use Module\Menu\Exception\MenusNotFoundException;
use Module\Menu\Exception\MenuExpectOneButReceivedTooMuchException;
use Module\Menu\Mapper\MenuFromRowMapper;

class MenuRetrieveManyByCriteriaDAO extends \UUA\DAO
{

    use \Module\Menu\Traits\MenuDbalDAOTrait;
    use \SetCMS\DAO\DAOEntityRetrieveByCriteriaTrait;

    /**
     * @var array<MenuEntity>
     */
    public array $menus;
    public MenuEntity $menu;
    public ?MenuEntity $menuOrNull = null;

    #[\Override]
    protected function handleRows(array $rows): void
    {
        $this->menus = array_map(fn($row) => MenuFromRowMapper::call($this->container, $row)->menu, $rows);
        $this->menus ? $this->menu = $this->menuOrNull = $this->menus[0] : null;
    }

    #[\Override]
    protected function entitiesNotFoundException(): \Throwable
    {
        return new MenusNotFoundException();
    }

    #[\Override]
    protected function entityExpectOneButReceivedTooMuchException(): \Throwable
    {
        return new MenuExpectOneButReceivedTooMuchException();
    }

    #[\Override]
    protected function entityNotFoundException(): \Throwable
    {
        return new MenuNotFoundException();
    }
}
