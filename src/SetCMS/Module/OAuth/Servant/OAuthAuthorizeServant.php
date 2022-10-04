<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\Servant;

use SetCMS\UUID;
use SetCMS\Module\OAuth\OAuthCode\OAuthCodeEntity;
use SetCMS\Module\OAuth\OAuthCode\DAO\OAuthCodeEntityDbSaveDAO;
use SetCMS\Module\OAuth\OAuthClient\OAuthClientException;
use SetCMS\Module\OAuth\OAuthClient\DAO\OAuthClientEntityRetrieveByClientIdDAO;
use SetCMS\Module\User\DAO\UserEntityDbRetrieveByUsernameAndPasswordDAO;

class OAuthAuthorizeServant implements \SetCMS\ServantInterface
{

    use \SetCMS\DITrait;
    use \SetCMS\FactoryTrait;

    public string $clientId;
    public string $username;
    public string $password;
    public ?OAuthCodeEntity $oauthCode = null;

    public function serve(): void
    {

        $retrieveUser = UserEntityDbRetrieveByUsernameAndPasswordDAO::make($this->factory());
        $retrieveUser->username = $this->username;
        $retrieveUser->password = $this->password;
        $retrieveUser->serve();

        $user = $retrieveUser->entity;

        if (empty($user)) {
            throw new \Exception('Пользователь не найден');
        }
        
        $retrieveOAuthClient = OAuthClientEntityRetrieveByClientIdDAO::make($this->factory());
        $retrieveOAuthClient->clientId = $this->clientId;
        $retrieveOAuthClient->serve();

        $client = $retrieveOAuthClient->oauthClient;

        if (empty($client)) {
            throw new \Exception('Приложение для авторизации не найдено');
        }

        if (!$client->isAuthorizable) {
            throw OAuthClientException::autorizationNotAllow();
        }

        $oauthCode = new OAuthCodeEntity;
        $oauthCode->userId = (string) $user->id;
        $oauthCode->clientId = (string) $client->id;

        $saveOAuthCode = OAuthCodeEntityDbSaveDAO::make($this->factory());
        $saveOAuthCode->entity = $oauthCode;
        $saveOAuthCode->serve();

        $this->oauthCode = $oauthCode;
    }

}
