<?php

declare(strict_types=1);

namespace SetCMS\Module\User\Controller;

use SetCMS\UUID;
use SetCMS\Controller;
use SetCMS\Module\UserSession\DAO\UserSessionDeleteByIdDAO;
use SetCMS\Module\User\View\UserPublicLogoutView;

class UserPublicLogoutController extends Controller
{

    protected UUID $token;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
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
    protected function process(): void
    {
        $validationCookies = $this->validation($this->request->getCookieParams());

        $this->token = $validationCookies->uuid('X-CSRF-Token')->notEmpty()->notQuite()->val();
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof UserSessionDeleteByIdDAO) {
            $object->id = $this->token;
        }
    }
}
