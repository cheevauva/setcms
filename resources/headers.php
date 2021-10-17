<?php

return [
    'OAuth.Index.callback' => function (\Psr\Http\Message\ServerRequestInterface $request, \Psr\Http\Message\ResponseInterface $response) {
        $model = $request->getAttribute('model');
        $router = $request->getAttribute('router');
        
        assert($model instanceof \SetCMS\Module\OAuth\OAuthModel\OAuthModelCallback);
        assert($router instanceof \SetCMS\Router);
        
        if (!$model->token()) {
            return $response;
        }
        
        $token = base64_encode($model->token()['access_token']);

        $response = $response->withHeader('Set-Cookie', sprintf('Authorization=%s;Path=/;SameSite=Strict', $token));
        $response = $response->withHeader('Location', $router->generate('home'));

        return $response;
    },
    'OAuth.Index.logout' => function (\Psr\Http\Message\ServerRequestInterface $request, \Psr\Http\Message\ResponseInterface $response) {
        return $response->withHeader('Location', $request->getAttribute('router')->generate('home'));
    }
];
