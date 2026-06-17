<?php

declare(strict_types=1);

namespace Module\Menu\Controller;

use Module\Menu\DAO\MenuRetrieveManyByCriteriaDAO;
use Module\Menu\Mapper\MenuSlugFromRequestMapper;

class MenuPublicReadBySlugController extends \SetCMS\Controller\ControllerViaPSR7
{

    protected string $slug;

    /**
     * @var array<mixed>
     */
    protected array $items = [];

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            MenuSlugFromRequestMapper::class,
            MenuRetrieveManyByCriteriaDAO::class,
        ];
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof MenuRetrieveManyByCriteriaDAO) {
            $object->slug = $this->slug;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof MenuSlugFromRequestMapper) {
            $this->slug = $object->slug;
        }
    }
}
