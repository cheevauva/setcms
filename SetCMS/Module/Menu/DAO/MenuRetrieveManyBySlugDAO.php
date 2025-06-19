<?php

declare(strict_types=1);

namespace SetCMS\Module\Menu\DAO;

use SetCMS\Module\Menu\Entity\MenuEntity;

class MenuRetrieveManyBySlugDAO extends \UUA\DAO
{

    use \SetCMS\Traits\DatabaseMainConnectionTrait;

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
