<?php

namespace SetCMS\Controller\Hook;

use SetCMS\Scope;
use SetCMS\Module\User\UserEntity;
use SetCMS\RequestAttribute;
use Psr\Http\Message\ServerRequestInterface;

class ScopeProtectionHook implements \SetCMS\Application\Contract\ContractApplicable
{

    use \SetCMS\Traits\EventTrait;

    public Scope $scope;
    public ?UserEntity $user = null;

    public function from(object $object): void
    {
        if ($object instanceof ServerRequestInterface) {
            $this->user = RequestAttribute::currentUser->fromRequest($object);
        }
    }

    public function to(object $object): void
    {
        
    }

}
