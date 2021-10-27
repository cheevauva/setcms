<?php

return [
    \SetCMS\Module\Users\UserEvent\RegistrationUserEvent::class => [
        \SetCMS\Module\OAuth\OAuthUserEventHandler\RegistrationUserEventHandler::class,
    ],
];
