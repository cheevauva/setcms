<?php

return [
    \SetCMS\Module\Users\UserEvent\RegistrationUserEvent::class => [
        \SetCMS\Module\OAuth\OAuthUserEventHandler\RegistrationUserEventHandler::class,
    ],
    \SetCMS\Event\FrontControllerBeforeLaunchActionEvent::class => [
        \SetCMS\Module\OAuth\Event\RetrieveCurrentUserByOAuthTokenEventHandler::class,
        \SetCMS\Module\Users\UserEvent\VerifyAccessEventHandler::class,
    ],
];
