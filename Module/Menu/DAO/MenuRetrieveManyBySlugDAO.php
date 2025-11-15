<?php

declare(strict_types=1);

namespace Module\Menu\DAO;

use Module\Menu\Entity\MenuEntity;

class MenuRetrieveManyBySlugDAO extends \UUA\DAO
{

    use \SetCMS\Traits\DatabaseMainTrait;

    public string $slug;

    /**
     * @var MenuEntity[]
     */
    public array $menuItems;

    #[\Override]
    public function serve(): void
    {
        $this->menuItems = [];
    }
}
