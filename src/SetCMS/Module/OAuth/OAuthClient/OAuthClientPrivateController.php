<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\OAuthClient;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\OAuth\OAuthClient\Form\OAuthClientIndexForm;
use SetCMS\Module\OAuth\OAuthClient\Scope\OAuthClientPrivateEditScope;
use SetCMS\Module\OAuth\OAuthClient\Form\OAuthClientSaveForm;
use SetCMS\Module\OAuth\OAuthClient\DAO\OAuthClientEntityRetrieveByIdDAO;
use SetCMS\Module\OAuth\OAuthClient\DAO\OAuthClientEntityRetrieveManyDAO;
use SetCMS\Module\OAuth\OAuthClient\DAO\OAuthClientEntitySaveDAO;
use SetCMS\Module\OAuth\OAuthClient\OAuthClientEntity;
use SetCMS\UUID;

class OAuthClientPrivateController
{

    use \SetCMS\Controller\ControllerTrait;
    use \SetCMS\Controller\DynamicControllerTrait;
    use \SetCMS\Router\RouterTrait;

    public function index(OAuthClientIndexForm $form, OAuthClientEntityRetrieveManyDAO $servant): OAuthClientIndexForm
    {
        return $this->serve($servant, $form, []);
    }

//    public function new(OAuthClientEntitySaveDAO $servant)
//    {
//        $oauthClient = new OAuthClientEntity;
//        $oauthClient->name = 'test';
//        $oauthClient->redirectURI = '';
//        $oauthClient->loginUrl = '';
//        $oauthClient->autorizationCodeUrl = '';
//        $oauthClient->userInfoUrl = '';
//        $oauthClient->userInfoParserRule = '';
//        $oauthClient->clientId = new UUID;
//
//        $servant->entity = $oauthClient;
//        $servant->serve();
//    }

    public function new(ServerRequestInterface $request, OAuthClientPrivateEditScope $scope): OAuthClientPrivateEditScope
    {
        $this->protectScopeByRequest($scope, $request);

        return $scope;
    }

    public function read(ServerRequestInterface $request, PagePrivateReadScope $scope, PageEntityDbRetrieveByIdDAO $servant): PagePrivateReadScope
    {
        return $this->serve($request, $servant, $scope, [
            'id' => $request->getAttribute('id'),
        ]);
    }

    public function save(ServerRequestInterface $request, PagePrivateSaveScope $form, PageEntitySaveServant $servant): PagePrivateSaveScope
    {
        $servant->id = $request->getAttribute('id');

        return $this->serve($request, $servant, $form, $request->getParsedBody());
    }

    public function edit(ServerRequestInterface $request, PagePrivateEditScope $scope, PageEntityDbRetrieveByIdDAO $servant): PagePrivateEditScope
    {
        return $this->serve($request, $servant, $scope, [
            'id' => $request->getAttribute('id'),
        ]);
    }

}
