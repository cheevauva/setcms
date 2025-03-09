<?php

declare(strict_types=1);

namespace SetCMS\Module\User\Controller;

use SetCMS\Controller;
use SetCMS\Module\UserSession\DAO\UserSessionDeleteByIdDAO;
use SetCMS\UUID;
use SetCMS\Attribute\Http\Parameter\Cookies;

#[RequestMethod('GET')]
class UserPublicLogoutController extends Controller
{

    #[Cookies('X-CSRF-Token')]
    public UUID $token;

    #[\Override]
    protected function units(): array
    {
        return [
            UserSessionDeleteByIdDAO::class,
        ];
    }

    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof UserSessionDeleteByIdDAO) {
            $object->id = $this->token;
        }
    }
}
