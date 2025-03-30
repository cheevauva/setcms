<?php

declare(strict_types=1);

namespace SetCMS\Module\Menu\Controller;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\Menu\MenuAction\Entity\MenuActionEntity;
use SetCMS\Attribute\Http\Parameter\Request;
use SetCMS\Module\Post\Servant\PostMenuActionsByRequestServant;

class MenuPublicReadByContextController extends \SetCMS\Controller
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
            $object->currentUser = $this->request->getAttribute('currentUser');
            $object->context = $this->getMainRequest($this->request)->getAttribute('output');
        }
    }

    private function getMainRequest(ServerRequestInterface $request): ServerRequestInterface
    {
        if ($request->getAttribute('parentRequest') && $request->getAttribute('parentRequest') instanceof ServerRequestInterface) {
            return $this->getMainRequest($request->getAttribute('parentRequest'));
        }

        return $request;
    }
}
