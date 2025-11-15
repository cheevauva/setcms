<?php

declare(strict_types=1);

$routes['GET /user/profile UserProfile'] = \Module\User\Controller\UserPublicProfileController::class;
$routes['GET /user/login UserLogin'] = \Module\User\Controller\UserPublicLoginController::class;
$routes['POST /user/doLogin UserDoLogin'] = \Module\User\Controller\UserPublicDoLoginController::class;
$routes['GET /user/restore UserRestore'] = \Module\User\Controller\UserPublicRestoreController::class;
$routes['GET /user/resetPasswordByToken/[*:token] UserResetPasswordByToken'] = \Module\User\Controller\UserPublicResetPasswordByTokenController::class;
$routes['POST /user/doRestore UserDoRestore'] = \Module\User\Controller\UserPublicDoRestoreController::class;
$routes['GET /user/registration UserRegistration'] = \Module\User\Controller\UserPublicRegistrationController::class;
$routes['POST /user/doRegistration UserDoRegistration'] = \Module\User\Controller\UserPublicDoRegistrationController::class;
$routes['GET /user/logout UserLogout'] = \Module\User\Controller\UserPublicLogoutController::class;
$routes['GET /~/user/index AdminUserIndex'] = \Module\User\Controller\UserPrivateIndexController::class;
$routes['GET /~/user/read/[g:id] AdminUserRead'] = \Module\User\Controller\UserPrivateReadController::class;
$routes['GET /~/user/edit/[g:id] AdminUserEdit'] = \Module\User\Controller\UserPrivateEditController::class;
$routes['POST /~/user/update/[g:id] AdminUserUpdate'] = \Module\User\Controller\UserPrivateUpdateController::class;
