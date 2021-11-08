<?php

namespace SetCMS\Module\OAuth\Event;

use SetCMS\Event\FrontControllerBeforeLaunchActionEvent as Event;
use SetCMS\RequestAttribute;
use SetCMS\Module\OAuth\OAuthService;
use Psr\Http\Message\ServerRequestInterface;

class RetrieveCurrentUserByOAuthTokenEventHandler
{

    private OAuthService $oauthService;

    public function __construct(OAuthService $oauthService)
    {
        $this->oauthService = $oauthService;
    }

    protected function processAccessToken(ServerRequestInterface $request): ServerRequestInterface
    {
        $tokens = $this->oauthService->parseTokens(array_filter([
            $request->getHeaderLine('Authorization') ?? null,
            $request->getCookieParams()['X-SetCMS-AccessToken'] ?? null,
        ]));
        
        return $request->withAttribute(RequestAttribute::ACCESS_TOKEN, $tokens ? reset($tokens) : null);
    }

    public function __invoke(Event $event): Event
    {
        $request = $event->request;
        $request = $this->processAccessToken($request);

        $token = $request->getAttribute(RequestAttribute::ACCESS_TOKEN);
        $currentUser = $request->getAttribute('user', null);

        if ($token && !$currentUser) {
            try {
                $currentUser = $this->oauthService->getUserByAccessToken($token);
            } catch (\Exception $ex) {
                $currentUser = null;
            }
        }
        
        if (!$currentUser) {
            $currentUser = $this->oauthService->getUserByAccessToken('guest');
        }

        $request = $request->withAttribute('user', $currentUser);
        
        $event->request = $request;

        return $event;
    }

}
