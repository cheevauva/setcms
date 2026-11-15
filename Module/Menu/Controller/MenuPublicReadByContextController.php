<?php

declare(strict_types=1);

namespace Module\Menu\Controller;

use SetCMS\Compiler;
use SetCMS\Controller\ControllerBlockViaPSR7;
use Module\Menu\MenuAction\Entity\MenuActionEntity;
use Module\Menu\MenuAction\Servant\MenuActionsByRequestServant;
use Module\Menu\View\MenuPublicActionsViaContextView;
use Module\ACL\VO\ACLRoleVO;

class MenuPublicReadByContextController extends ControllerBlockViaPSR7
{

    /**
     * @var MenuActionEntity[]
     */
    protected array $items = [];

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            ...Compiler::singleton($this->container)->getAsArray('menuActions')
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

        if ($object instanceof MenuActionsByRequestServant) {
            array_push($this->items, ...$object->actions);
        }
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof MenuActionsByRequestServant) {
            $object->role = ACLRoleVO::fromRequest($this->request);
            $object->rootContext = $this->rootContext;
        }

        if ($object instanceof MenuPublicActionsViaContextView) {
            $object->items = $this->items;
        }
    }
}
