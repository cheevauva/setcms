<?php

declare(strict_types=1);

namespace Module\User\Controller;

use SetCMS\UUID;
use SetCMS\Controller\ControllerViaPSR7;
use Module\UserSession\DAO\UserSessionDeleteByIdDAO;
use Module\User\View\UserPublicLogoutView;
use Module\User\Mapper\UserTokenFromRequestMapper;

class UserPublicLogoutController extends ControllerViaPSR7
{

    protected UUID $token;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            UserTokenFromRequestMapper::class,
            UserSessionDeleteByIdDAO::class,
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            UserPublicLogoutView::class,
        ];
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof UserSessionDeleteByIdDAO) {
            $object->id = $this->token;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);
        
        if ($object instanceof UserTokenFromRequestMapper) {
            $this->token = $object->token;
        }
    }
}
