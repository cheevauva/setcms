<?php

declare(strict_types=1);

namespace SetCMS\Module\Menu\DAO;

class MenuRetrieveManyBySlugDAO implements \SetCMS\Contract\Servant
{

    public string $slug;
    public array $entities;

    public function serve(): void
    {
        $this->entities = [];
    }

}
