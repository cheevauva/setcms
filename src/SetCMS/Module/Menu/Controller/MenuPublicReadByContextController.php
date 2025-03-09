<?php

declare(strict_types=1);

namespace SetCMS\Module\Menu\Controller;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\Menu\Hook\MenuRetrieveActionsByContextHook;
use SetCMS\Module\Menu\MenuAction\Entity\MenuActionEntity;
use SetCMS\Attribute\Http\Parameter\Request;
use SetCMS\Attribute\ResponderPassProperty;

class MenuPublicReadByContextController extends \SetCMS\Controller
{

    /**
     * @var MenuActionEntity[]
     */
    #[ResponderPassProperty]
    protected array $items = [];

    #[Request]
    public ServerRequestInterface $currentRequest;

    #[\Override]
    protected function units(): array
    {
        return [
            MenuRetrieveActionsByContextHook::class,
        ];
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof MenuRetrieveActionsByContextHook) {
            $this->items = $object->actions;
        }
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof MenuRetrieveActionsByContextHook) {
            $object->request = $this->currentRequest;
        }
    }
}
