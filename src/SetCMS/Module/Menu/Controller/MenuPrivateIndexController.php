<?php

declare(strict_types=1);

namespace SetCMS\Module\Menu\Controller;

use SetCMS\Controller;
use SetCMS\Module\Menu\DAO\MenuRetrieveManyDAO;
use SetCMS\Attribute\Http\RequestMethod;
use SetCMS\Attribute\ResponderPassProperty;
use SetCMS\Module\Menu\Entity\MenuEntity;

#[RequestMethod('GET')]
class MenuPrivateIndexController extends Controller
{

    /**
     * @var MenuEntity[]
     */
    #[ResponderPassProperty]
    protected array $entities = [];

    #[\Override]
    protected function units(): array
    {
        return [
            MenuRetrieveManyDAO::class,
        ];
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof MenuRetrieveManyDAO) {
            $this->entities = $object->entities;
        }
    }
}
