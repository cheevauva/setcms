<?php

declare(strict_types=1);

namespace Module\Menu\Controller;

use SetCMS\Compiler;
use Module\Menu\MenuAction\Entity\MenuActionEntity;
use Module\Menu\MenuAction\Servant\MenuActionsByRequestServant;
use Module\Menu\View\MenuPublicActionsViaContextView;
use Module\Menu\Mapper\MenuReadByContextFromRequestMapper;
use Module\ACL\VO\ACLRoleVO;

class MenuPublicReadByContextController extends \SetCMS\Controller\ControllerViaPSR7
{

    /**
     * @var MenuActionEntity[]
     */
    protected array $items = [];
    protected string $queryParams;
    protected string $path;
    protected ACLRoleVO $role;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            MenuReadByContextFromRequestMapper::class,
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

        if ($object instanceof MenuReadByContextFromRequestMapper) {
            $this->queryParams = $object->queryParams;
            $this->path = $object->path;
            $this->role = $object->role;
        }
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof MenuActionsByRequestServant) {
            $object->queryParams = $this->queryParams;
            $object->path = $this->path;
            $object->role = $this->role;
        }

        if ($object instanceof MenuPublicActionsViaContextView) {
            $object->items = $this->items;
        }
    }
}
