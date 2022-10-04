<?php

namespace SetCMS\Module\OAuth\Servant;

use SetCMS\Event\FrontControllerBeforeLaunchActionEvent as Event;
use SetCMS\ServerRequestAttribute;
use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\OAuth\OAuthToken\DAO\OAuthTokenEntityRetrieveByAccessTokenDAO;
use SetCMS\Module\User\DAO\UserEntityDbRetrieveByIdDAO;
use SetCMS\Module\User\UserEntity;

class RetrieveCurrentUserByOAuthTokenServant implements \SetCMS\ServantInterface, \SetCMS\Contract\Applicable
{

    use \SetCMS\DITrait;

    public ServerRequestInterface $request;

    protected function processAccessToken(ServerRequestInterface $request): ServerRequestInterface
    {
        $tokens = $this->oauthService->parseTokens(array_filter([
            $request->getHeaderLine('Authorization') ?? null,
            $request->getCookieParams()['X-SetCMS-AccessToken'] ?? null,
        ]));

        return $request->withAttribute(ServerRequestAttribute::ACCESS_TOKEN, $tokens ? reset($tokens) : null);
    }

    public function apply(object $object): void
    {
        if ($object instanceof Event) {
            $this->request = $object->request;
        }
    }

    public function serve(): void
    {
        $this->request = $this->processAccessToken($this->request);

        $token = $this->request->getAttribute(ServerRequestAttribute::ACCESS_TOKEN);
        $currentUser = $this->request->getAttribute('user');

        if ($token && !$currentUser) {
            $currentUser = $this->getUserByAccessToken($token);
        }

        if (!$currentUser) {
            $currentUser = $this->getUserByAccessToken('guest');
        }

        $this->request = $this->request->withAttribute('user', $currentUser);
    }

    private function getUserByAccessToken(string $token): ?UserEntity
    {
        try {
            $retrieveAccessToken = OAuthTokenEntityRetrieveByAccessTokenDAO::make($this->factory());
            $retrieveAccessToken->accessToken = $token;
            $retrieveAccessToken->serve();

            $userById = UserEntityDbRetrieveByIdDAO::make($this->factory());
            $userById->id = $retrieveAccessToken->oauthToken->userId;
            $userById->serve();

            return $userById->entity;
        } catch (\Exception $ex) {
            return null;
        }
    }

}