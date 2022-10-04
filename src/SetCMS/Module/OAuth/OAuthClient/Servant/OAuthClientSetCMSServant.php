<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\OAuthClient\Servant;

use SetCMS\Module\OAuth\OAuthClient\OAuthClientSetCMSEntity;
use SetCMS\Module\OAuth\OAuthClient\DAO\OAuthClientEntitySaveDAO;
use SetCMS\Module\OAuth\OAuthClient\DAO\OAuthClientEntityRetrieveByEntityTypeDAO;

class OAuthClientSetCMSServant implements \SetCMS\ServantInterface
{

    use \SetCMS\DITrait;
    use \SetCMS\FactoryTrait;

    public ?OAuthClientSetCMSEntity $oauthClient = null;

    public function serve(): void
    {
        $retrieveSetCMSOAuthClient = OAuthClientEntityRetrieveByEntityTypeDAO::make($this->factory());
        $retrieveSetCMSOAuthClient->entityType = OAuthClientSetCMSEntity::class;
        $retrieveSetCMSOAuthClient->serve();

        if ($retrieveSetCMSOAuthClient->entity) {
            $this->oauthClient = $retrieveSetCMSOAuthClient->entity;
            return;
        }

        $entity = new OAuthClientSetCMSEntity;
        $entity->name = 'SetCMS';
        $entity->isAuthorizable = false;
        $entity->redirectURI = '';
        $entity->loginUrl = '';
        $entity->autorizationCodeUrl = '';
        $entity->userInfoUrl = '';
        $entity->userInfoParserRule = '';

        $saveOAuthClient = OAuthClientEntitySaveDAO::make($this->factory());
        $saveOAuthClient->entity = $entity;
        $saveOAuthClient->serve();

        $this->oauthClient = $entity;
    }

}
