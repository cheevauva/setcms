<?php

declare(strict_types=1);

namespace SetCMS\Module\Menu\Controller;

use SetCMS\Module\Menu\DAO\MenuRetrieveManyBySlugDAO;

class MenuPublicReadBySlugController extends \SetCMS\ControllerViaPSR7
{

    protected string $slug;

    /**
     * @var array<mixed>
     */
    protected array $items = [];
    
    #[\Override]
    protected function process(): void
    {
        $this->validation($this->request->getAttributes())->string('slug')->notQuiet()->val();
    }

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            MenuRetrieveManyBySlugDAO::class,
        ];
    }
}
