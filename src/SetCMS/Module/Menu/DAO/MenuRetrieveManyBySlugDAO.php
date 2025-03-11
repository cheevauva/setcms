<?php

declare(strict_types=1);

namespace SetCMS\Module\Menu\DAO;

class MenuRetrieveManyBySlugDAO extends \UUA\DAO
{

    use \SetCMS\Traits\DatabaseMainConnectionTrait;

    public string $slug;
    public array $entities;

    #[\Override]
    public function serve(): void
    {
        $this->entities = [];
    }
}
