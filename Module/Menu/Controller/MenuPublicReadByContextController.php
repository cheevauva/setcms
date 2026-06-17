<?php

declare(strict_types=1);

namespace Module\Menu\Controller;

use Module\Menu\MenuAction\Entity\MenuActionEntity;
use Module\Post\Servant\PostMenuActionsByRequestServant;
use Module\Page\Servant\PageMenuActionsByRequestServant;
use Module\Menu\View\MenuPublicActionsViaContextView;
use Module\Menu\Mapper\MenuReadByContextFromRequestMapper;
use SetCMS\View\View;
use SetCMS\Responder;
use SetCMS\UseCase\ACL\VO\ACLRoleVO;

class MenuPublicReadByContextController extends \SetCMS\Controller\ControllerViaPSR7
{

    /**
     * @var MenuActionEntity[]
     */
    protected array $items = [];
    protected View|Responder $view;
    protected ACLRoleVO $role;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            MenuReadByContextFromRequestMapper::class,
            PostMenuActionsByRequestServant::class,
            PageMenuActionsByRequestServant::class,
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
            array_push($this->items, ...$object->actions);
        }

        if ($object instanceof PageMenuActionsByRequestServant) {
            array_push($this->items, ...$object->actions);
        }

        if ($object instanceof MenuReadByContextFromRequestMapper) {
            $this->view = $object->view;
            $this->role = $object->role;
        }
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof PostMenuActionsByRequestServant) {
            $object->view = $this->view;
            $object->role = $this->role;
        }

        if ($object instanceof PageMenuActionsByRequestServant) {
            $object->view = $this->view;
            $object->role = $this->role;
        }

        if ($object instanceof MenuPublicActionsViaContextView) {
            $object->items = $this->items;
        }
    }
}
