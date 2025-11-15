<?php

declare(strict_types=1);

namespace Module\Menu\Controller;

use Module\Menu\DAO\MenuRetrieveManyBySlugDAO;

class MenuPublicReadBySlugController extends \SetCMS\Controller\ControllerViaPSR7
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
