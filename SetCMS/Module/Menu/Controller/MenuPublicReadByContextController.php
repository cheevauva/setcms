<?php

declare(strict_types=1);

namespace SetCMS\Module\Menu\Controller;

use SetCMS\Module\Menu\MenuAction\Entity\MenuActionEntity;
use SetCMS\Module\Post\Servant\PostMenuActionsByRequestServant;
use SetCMS\Module\Menu\View\MenuPublicActionsViaContextView;

class MenuPublicReadByContextController extends \SetCMS\ControllerViaPSR7
{

    /**
     * @var MenuActionEntity[]
     */
    protected array $items = [];

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            PostMenuActionsByRequestServant::class,
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            MenuPublicActionsViaContextView::class,
        ];
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof PostMenuActionsByRequestServant) {
            $this->items += $object->actions;
        }
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof PostMenuActionsByRequestServant) {
            $object->ctx = $this->ctx;
        }

        if ($object instanceof MenuPublicActionsViaContextView) {
            $object->items = $this->items;
        }
    }
}
