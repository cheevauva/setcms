<?php

return [
    'OAuth.Index.callback' => function (\Psr\Http\Message\ServerRequestInterface $request, \Psr\Http\Message\ResponseInterface $response) {
        $model = $request->getAttribute('model');
        $router = $request->getAttribute('router');

        assert($model instanceof \SetCMS\Module\OAuth\OAuthModel\OAuthCallbackScope);
        assert($router instanceof \SetCMS\Router);

        if (!$model->entity()) {
            return $response;
        }
        
        $response = $response->withHeader('Set-Cookie', sprintf('X-SetCMS-AccessToken=%s;Path=/', $model->entity()->token));
        $response = $response->withHeader('Location', $router->generate('home'));

        return $response;
    },
    'OAuth.Index.logout' => function (\Psr\Http\Message\ServerRequestInterface $request, \Psr\Http\Message\ResponseInterface $response) {
        return $response->withHeader('Location', $request->getAttribute('router')->generate('home'));
    }
];
