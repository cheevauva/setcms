<?php

declare(strict_types=1);

$routes['action_oauthclients_admin'] = ['GET', '/~/OAuth/OAuthClient/[a:action]', SetCMS\Module\OAuth\OAuthClient\OAuthClientPrivateController::toRoute()->dynamicAction()];
$routes['action_oauthclients_record_admin'] = ['GET', '/~/OAuth/OAuthClient/[a:action]/[g:id]', SetCMS\Module\OAuth\OAuthClient\OAuthClientPrivateController::toRoute()->dynamicAction()];
