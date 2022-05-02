<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\Servant;

class OAuthCallbackServant implements \SetCMS\ServantInterface
{

    public string $clientId;
    public string $code;
    public string $cmsToken;

    public function serve(): void
    {
        $oauthClient = $this->oauthClientDAO->get($this->clientId);
        $oauthData = $this->oauthClientDAO->getTokenByAuthorizationCodeAndClient($this->code, $oauthClient);

        assert($oauthClient instanceof OAuthClient);

        $externalId = $this->getExternalId($oauthData, $oauthClient);

        if (empty($externalId)) {
            throw OAuthClientException::internalError('externalId empty');
        }

        try {
            $user = $this->getUserByAccessToken((string) $this->cmsToken);

            try {
                $oauthUser = $this->oauthUserDAO->getByExternalIdAndClient($externalId, $oauthClient);
            } catch (NotFound $ex) {
                $oauthUser = new OAuthUser;
            }
        } catch (NotFound $ex) {
            try {
                $oauthUser = $this->oauthUserDAO->getByExternalIdAndClient($externalId, $oauthClient);
                $user = $this->userService->getById($oauthUser->userId);
            } catch (NotFound $ex) {
                $oauthUser = new OAuthUser;
                $user = $this->userService->createUser($oauthClient->name . $externalId, microtime(true));
            }
        }

        $oauthUser->clientId = $oauthClient->id;
        $oauthUser->externalId = $externalId;
        $oauthUser->userId = $user->id;
        $oauthUser->refreshToken = $oauthData['refresh_token'] ?? '';

        $this->oauthUserDAO->save($oauthUser);

        $oauthToken = $this->generateToken($user, $oauthClient, '+1 year');
    }

}
