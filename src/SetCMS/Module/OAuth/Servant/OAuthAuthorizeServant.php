<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\Servant;

use SetCMS\Module\OAuth\OAuthApp\DAO\OAuthAppEntityRetrieveByClientIdDAO;
use SetCMS\Module\OAuth\OAuthAppCode\OAuthAppCodeEntity;
use SetCMS\Module\OAuth\OAuthAppCode\DAO\OAuthAppCodeEntityDbSaveDAO;
use SetCMS\Module\User\DAO\UserEntityDbRetrieveByUsernameAndPasswordDAO;

class OAuthAuthorizeServant implements \SetCMS\ServantInterface
{

    use \SetCMS\DITrait;
    use \SetCMS\FactoryTrait;

    public string $clientId;
    public string $username;
    public string $password;
    public ?OAuthAppCodeEntity $oauthAppCode = null;

    public function serve(): void
    {
        $retrieveApp = OAuthAppEntityRetrieveByClientIdDAO::make($this->factory());
        $retrieveApp->clientId = $this->clientId;
        $retrieveApp->serve();

        $app = $retrieveApp->oauthApp;

        if (empty($app)) {
            throw new \Exception('Приложение для авторизации не найдено');
        }

        $retrieveUser = UserEntityDbRetrieveByUsernameAndPasswordDAO::make($this->factory());
        $retrieveUser->username = $this->username;
        $retrieveUser->password = $this->password;
        $retrieveUser->serve();

        if (empty($retrieveUser->entity)) {
            throw new \Exception('Пользователь не найден');
        }

        $code = new OAuthAppCodeEntity;
        $code->userId = $retrieveUser->entity->id;
        $code->appId = $app->id;

        $saveCode = OAuthAppCodeEntityDbSaveDAO::make($this->factory());
        $saveCode->entity = $code;
        $saveCode->serve();

        $this->oauthAppCode = $code;
    }

}
