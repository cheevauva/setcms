<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\OAuthClient;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\OAuth\OAuthClient\Form\OAuthClientIndexForm;
use SetCMS\Module\OAuth\OAuthClient\Form\OAuthClientSaveForm;
use SetCMS\Module\OAuth\OAuthClient\DAO\OAuthClientEntityDbRetrieveByIdDAO;
use SetCMS\Module\OAuth\OAuthClient\DAO\OAuthClientEntityDbRetrieveManyDAO;
use SetCMS\Module\OAuth\OAuthClient\DAO\OAuthClientEntityDbSaveDAO;
use SetCMS\Module\OAuth\OAuthClient\OAuthClientEntity;
use SetCMS\UUID;

class OAuthClientPrivateController
{

    use \SetCMS\Controller\ControllerTrait;
    use \SetCMS\Controller\DynamicControllerTrait;
    use \SetCMS\Router\RouterTrait;

    public function index(OAuthClientIndexForm $form, OAuthClientEntityDbRetrieveManyDAO $servant): OAuthClientIndexForm
    {
        return $this->serve($servant, $form, []);
    }

    public function new(OAuthClientEntityDbSaveDAO $servant)
    {
        $oauthClient = new OAuthClientEntity;
        $oauthClient->name = 'test';
        $oauthClient->redirectURI = '';
        $oauthClient->loginUrl = '';
        $oauthClient->autorizationCodeUrl = '';
        $oauthClient->userInfoUrl = '';
        $oauthClient->userInfoParserRule = '';
        $oauthClient->clientId = new UUID;

        $servant->entity = $oauthClient;
        $servant->serve();
    }

    public function save(ServerRequestInterface $request, OAuthClientSaveForm $form, OAuthClientEntityDbRetrieveByIdDAO $servant): OAuthClientSaveForm
    {
        return $this->serve($servant, $form, [
            'id' => $request->getAttribute('id'),
        ]);
    }

}
