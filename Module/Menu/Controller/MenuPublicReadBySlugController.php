<?php

declare(strict_types=1);

namespace Module\Menu\Controller;

use Module\Menu\DAO\MenuRetrieveManyByCriteriaDAO;

class MenuPublicReadBySlugController extends \SetCMS\Controller\ControllerViaPSR7
{

    protected string $slug;

    /**
     * @var array<mixed>
     */
    protected array $items = [];

    #[\Override]
    protected function fromRequest(): void
    {
        $this->slug = $this->validationParams()->string('slug')->notQuiet()->val();
    }

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            MenuRetrieveManyByCriteriaDAO::class,
        ];
    }
}
