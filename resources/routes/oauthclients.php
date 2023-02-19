<?php

declare(strict_types=1);

$routes['action_oauthclients_admin'] = ['GET', '/~/OAuth/OAuthClient/[a:action]', SetCMS\Module\OAuth\OAuthClient\OAuthClientPrivateController::toRoute()->dynamicAction()];
$routes['action_oauthclients_record_admin'] = ['GET', '/~/OAuth/OAuthClient/[a:action]/[g:id]', SetCMS\Module\OAuth\OAuthClient\OAuthClientPrivateController::toRoute()->dynamicAction()];
$routes['do_action_oauthclients_admin'] = ['POST', '/~/OAuth/OAuthClient/[a:action]', SetCMS\Module\OAuth\OAuthClient\OAuthClientPrivateController::toRoute()->dynamicAction()];
$routes['do_action_oauthclients_record_admin'] = ['POST', '/~/OAuth/OAuthClient/[a:action]/[g:id]', SetCMS\Module\OAuth\OAuthClient\OAuthClientPrivateController::toRoute()->dynamicAction()];
//
$routes['action_oauthapps_admin'] = ['GET', '/~/OAuth/OAuthApp/[a:action]', SetCMS\Module\OAuth\OAuthApp\OAuthAppPrivateController::toRoute()->dynamicAction()];
$routes['action_oauthapps_record_admin'] = ['GET', '/~/OAuth/OAuthApp/[a:action]/[g:id]', SetCMS\Module\OAuth\OAuthApp\OAuthAppPrivateController::toRoute()->dynamicAction()];
$routes['do_action_oauthapps_admin'] = ['POST', '/~/OAuth/OAuthApp/[a:action]', SetCMS\Module\OAuth\OAuthApp\OAuthAppPrivateController::toRoute()->dynamicAction()];
$routes['do_action_oauthapps_record_admin'] = ['POST', '/~/OAuth/OAuthApp/[a:action]/[g:id]', SetCMS\Module\OAuth\OAuthApp\OAuthAppPrivateController::toRoute()->dynamicAction()];