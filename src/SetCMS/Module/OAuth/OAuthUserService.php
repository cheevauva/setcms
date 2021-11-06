<?php

namespace SetCMS\Module\OAuth;

use SetCMS\Module\Ordinary\OrdinaryService;
use SetCMS\Module\OAuth\OAuthUser;
use SetCMS\Module\OAuth\OAuthUserDAO;
use SetCMS\Module\OAuth\OAuthClient;
use SetCMS\Module\Users\UserService;
use SetCMS\EventDispatcher;

class OAuthUserService extends OrdinaryService
{

    private OAuthUserDAO $oauthUserDAO;
    private UserService $userService;
    private EventDispatcher $eventDispatcher;

    public function __construct(OAuthUserDAO $oauthUserDAO, UserService $userService, EventDispatcher $eventDispatcher)
    {
        $this->oauthUserDAO = $oauthUserDAO;
        $this->userService = $userService;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function createOAuthUserForGuest(OAuthClient $client)
    {
        $user = $this->userService->getGuestUser();

        $oauthUser = $this->entity();
        $oauthUser->clientId = $client->id;
        $oauthUser->externalId = $user->id;
        $oauthUser->refreshToken = '';
        $oauthUser->userId = $user->id;

        $this->dao()->save($oauthUser);
    }

    public function createOAuthUserForAdmin(OAuthClient $client)
    {
        $user = $this->userService->getMainAdminUser();

        $oauthUser = $this->entity();
        $oauthUser->clientId = $client->id;
        $oauthUser->externalId = $user->id;
        $oauthUser->refreshToken = '';
        $oauthUser->userId = $user->id;

        $this->dao()->save($oauthUser);
    }

    protected function dao(): OAuthUserDAO
    {
        return $this->oauthUserDAO;
    }

    public function entity(): OAuthUser
    {
        return new OAuthUser;
    }

}
