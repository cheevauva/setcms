<?php

declare(strict_types=1);

$routes['GET /user/profile UserProfile'] = \SetCMS\Module\User\Controller\UserPublicProfileController::class;
$routes['GET /user/login UserLogin'] = \SetCMS\Module\User\Controller\UserPublicLoginController::class;
$routes['POST /user/doLogin UserDoLogin'] = \SetCMS\Module\User\Controller\UserPublicDoLoginController::class;
$routes['GET /user/restore UserRestore'] = \SetCMS\Module\User\Controller\UserPublicRestoreController::class;
$routes['GET /user/resetPasswordByToken/[*:token] UserResetPasswordByToken'] = \SetCMS\Module\User\Controller\UserPublicResetPasswordByTokenController::class;
$routes['POST /user/doRestore UserDoRestore'] = \SetCMS\Module\User\Controller\UserPublicDoRestoreController::class;
$routes['GET /user/registration UserRegistration'] = \SetCMS\Module\User\Controller\UserPublicRegistrationController::class;
$routes['POST /user/doRegistration UserDoRegistration'] = \SetCMS\Module\User\Controller\UserPublicDoRegistrationController::class;
$routes['GET /user/logout UserLogout'] = \SetCMS\Module\User\Controller\UserPublicLogoutController::class;
$routes['GET /~/user/index AdminUserIndex'] = \SetCMS\Module\User\Controller\UserPrivateIndexController::class;
$routes['GET /~/user/read/[g:id] AdminUserRead'] = \SetCMS\Module\User\Controller\UserPrivateReadController::class;
$routes['GET /~/user/edit/[g:id] AdminUserEdit'] = \SetCMS\Module\User\Controller\UserPrivateEditController::class;
$routes['POST /~/user/update/[g:id] AdminUserUpdate'] = \SetCMS\Module\User\Controller\UserPrivateUpdateController::class;
