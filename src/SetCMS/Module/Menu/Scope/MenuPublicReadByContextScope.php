<?php

declare(strict_types=1);

namespace SetCMS\Module\Menu\Scope;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Attribute\Http\Parameter\Request;
use SetCMS\Module\Menu\Hook\MenuRetrieveActionsByContextHook;

class MenuPublicReadByContextScope extends \SetCMS\Scope
{

    private array $items = [];

    #[Request]
    public ServerRequestInterface $currentRequest;

    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof MenuRetrieveActionsByContextHook) {
            $this->items = $object->actions;
        }
    }

    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof MenuRetrieveActionsByContextHook) {
            $object->request = $this->currentRequest;
        }
    }

    public function toArray(): array
    {
        $return = parent::toArray();
        $return['items'] = $this->items;

        return $return;
    }

}
