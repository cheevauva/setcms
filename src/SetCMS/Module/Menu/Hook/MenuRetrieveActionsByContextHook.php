<?php

declare(strict_types=1);

namespace SetCMS\Module\Menu\Hook;

use SetCMS\Module\Menu\MenuAction\Entity\MenuActionEntity;
use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\User\Entity\UserEntity;

class MenuRetrieveActionsByContextHook implements \SetCMS\Application\Contract\ContractServant
{

    use \SetCMS\Traits\HookTrait;
    use \SetCMS\Traits\EventDispatcherTrait;

    /**
     * @var MenuActionEntity[]
     */
    public array $actions = [];
    public ServerRequestInterface $request;
    public ServerRequestInterface $mainRequest;
    public UserEntity $currentUser;
    public mixed $context;

    public function serve(): void
    {
        $this->currentUser = $this->request->getAttribute('currentUser');
        $this->mainRequest = $this->getMainRequest($this->request);
        $this->context = $this->mainRequest->getAttribute('output');
        $this->dispatch($this->eventDispatcher());
    }

    private function getMainRequest(ServerRequestInterface $request): ServerRequestInterface
    {
        if ($request->getAttribute('parentRequest') && $request->getAttribute('parentRequest') instanceof ServerRequestInterface) {
            return $this->getMainRequest($request->getAttribute('parentRequest'));
        }

        return $request;
    }

}
