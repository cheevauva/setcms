<?php

declare(strict_types=1);

namespace SetCMS\Module\Menu\Controller;

use SetCMS\Attribute\Http\Parameter\Attributes;
use SetCMS\Module\Menu\DAO\MenuRetrieveManyBySlugDAO;

class MenuPublicReadBySlugController extends \SetCMS\Controller
{

    #[Attributes('slug')]
    public string $slug;

    /**
     * @var array<mixed>
     */
    protected array $items = [];

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            MenuRetrieveManyBySlugDAO::class,
        ];
    }
}
