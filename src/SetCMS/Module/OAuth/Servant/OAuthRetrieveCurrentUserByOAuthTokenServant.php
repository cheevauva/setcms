<?php

namespace SetCMS\Module\OAuth\Servant;

use SetCMS\Controller\Event\FrontControllerResolveEvent as Event;
use SetCMS\ServerRequestAttribute;
use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\OAuth\OAuthToken\DAO\OAuthTokenEntityRetrieveByAccessTokenDAO;
use SetCMS\Module\User\DAO\UserEntityDbRetrieveByIdDAO;
use SetCMS\Module\User\UserEntity;

class OAuthRetrieveCurrentUserByOAuthTokenServant implements \SetCMS\ServantInterface, \SetCMS\Contract\Applicable
{

    use \SetCMS\DITrait;

    public ServerRequestInterface $request;
    private ?Event $event = null;

    public function parseTokens(array $tokens): array
    {
        $parsedTokens = [];

        foreach ($tokens as $token) {
            $parsed = array_filter(explode(' ', $token, 2));

            if (empty($parsed)) {
                continue;
            }

            if (count($parsed) === 1) {
                $parsedTokenType = 'Bearer';
                $parsedToken = reset($parsed);
            } else {
                list($parsedTokenType, $parsedToken) = $parsed;
            }

            switch ($parsedTokenType) {
                case 'Bearer':
                    $parsedTokens[] = $parsedToken;
                    break;
            }
        }

        return $parsedTokens;
    }

    protected function processAccessToken(ServerRequestInterface $request): ServerRequestInterface
    {
        $tokens = $this->parseTokens(array_filter([
            $request->getHeaderLine('Authorization') ?? null,
            $request->getCookieParams()['X-SetCMS-AccessToken'] ?? null,
        ]));

        return $request->withAttribute(ServerRequestAttribute::ACCESS_TOKEN, $tokens ? reset($tokens) : null);
    }

    public function apply(object $object): void
    {
        if ($object instanceof Event) {
            $this->request = $object->request;
            $this->event = $object;
        }
    }

    public function serve(): void
    {
        $this->request = $this->processAccessToken($this->request);

        $token = $this->request->getAttribute(ServerRequestAttribute::ACCESS_TOKEN);

        $currentUser = $this->request->getAttribute(ServerRequestAttribute::CURRENT_USER);

        if ($token && !$currentUser) {
            $currentUser = $this->getUserByAccessToken($token);
        }

        if (!$currentUser) {
            $currentUser = new UserEntity;
        }

        $this->request = $this->request->withAttribute(ServerRequestAttribute::CURRENT_USER, $currentUser);
        
        if ($this->event) {
            $this->event->request = $this->request;
        }
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
