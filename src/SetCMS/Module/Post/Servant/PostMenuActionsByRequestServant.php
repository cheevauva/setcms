<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Servant;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Contract\ContractRouterInterface;
use SetCMS\Module\Menu\Hook\MenuRetrieveActionsByContextHook;
use SetCMS\Module\Menu\MenuAction\Entity\MenuActionEntity;
use SetCMS\Module\Post\Scope\PostPublicReadBySlugScope;
use SetCMS\Module\Post\Scope\PostPublicIndexScope;
use SetCMS\Module\Post\DAO\PostRetrieveBySlugDAO;

class PostMenuActionsByRequestServant implements \SetCMS\Contract\Servant, \SetCMS\Contract\Applicable
{

    use \SetCMS\DITrait;

    private ?MenuRetrieveActionsByContextHook $hook = null;

    public function serve(): void
    {
        $context = $this->hook->context;

        if ($context instanceof PostPublicReadBySlugScope) {
            if ($this->hook->currentUser->isAdmin()) {
                $this->hook->actions[] = $this->prepareEditAction($context->slug);
                $this->hook->actions[] = $this->prepareIndexAction();
            }
        }

        if ($context instanceof PostPublicIndexScope) {
            if ($this->hook->currentUser->isAdmin()) {
                $this->hook->actions[] = $this->prepareIndexAction();
            }
        }
    }

    private function prepareIndexAction(): MenuActionEntity
    {
        $indexAction = new MenuActionEntity;
        $indexAction->label = 'Список постов';
        $indexAction->route = $this->router()->generate('action_admin', [
            'module' => 'Post',
            'action' => 'index',
        ]);

        return $indexAction;
    }

    private function prepareEditAction(string $slug): MenuActionEntity
    {
        $retrieveBySlug = PostRetrieveBySlugDAO::make($this->factory());
        $retrieveBySlug->slug = $slug;
        $retrieveBySlug->serve();

        $editAction = new MenuActionEntity;
        $editAction->label = 'Редактировать пост';
        $editAction->route = $this->router()->generate('action_record_admin', [
            'module' => 'Post',
            'action' => 'edit',
            'id' => $retrieveBySlug->post->id->uuid,
        ]);

        return $editAction;
    }

    private function router(): ContractRouterInterface
    {
        return $this->container->get(ContractRouterInterface::class);
    }

    public function from(object $object): void
    {
        if ($object instanceof MenuRetrieveActionsByContextHook) {
            $this->hook = $object;
        }
    }

    public function to(object $object): void
    {
        
    }

}
