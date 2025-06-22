<?php

use SetCMS\Module\User\Enum\UserRoleEnum;

$acl = [
    'roles' => [
        UserRoleEnum::GUEST->toString() => [],
        UserRoleEnum::USER->toString() => [
            UserRoleEnum::GUEST->toString()
        ],
        UserRoleEnum::ADMIN->toString() => [
            UserRoleEnum::USER->toString()
        ],
    ],
    'rules' => [
        UserRoleEnum::GUEST->toString() => [
            'scope' => [
                \SetCMS\Module\Captcha\Controller\CaptchaPublicGenerateController::class => true,
                \SetCMS\Module\Captcha\Controller\CaptchaPublicSolveController::class => true,
                // User
                \SetCMS\Module\User\Controller\UserPublicLoginController::class => true,
                \SetCMS\Module\User\Controller\UserPublicDoLoginController::class => true,
                \SetCMS\Module\User\Controller\UserPublicRegistrationController::class => true,
                \SetCMS\Module\User\Controller\UserPublicDoRegistrationController::class => true,
                \SetCMS\Module\User\Controller\UserPublicProfileController::class => false,
                \SetCMS\Module\User\Controller\UserInfoController::class => false,
                \SetCMS\Module\User\Controller\UserPublicRestoreController::class => true,
                \SetCMS\Module\User\Controller\UserPublicDoRestoreController::class => true,
                // Post
                \SetCMS\Module\Post\Controller\PostPublicIndexController::class => true,
                \SetCMS\Module\Post\Controller\PostPublicReadBySlugController::class => true,
                // Page
                \SetCMS\Module\Page\Controller\PagePublicReadBlockBySlugController::class => true,
                \SetCMS\Module\Page\Controller\PagePublicReadBySlugController::class => true,
            ],
        ],
        UserRoleEnum::USER->toString() => [
            'scope' => [
                \SetCMS\Module\User\Controller\UserPublicProfileController::class => true,
                \SetCMS\Module\User\Controller\UserPublicRegistrationController::class => false,
                \SetCMS\Module\User\Controller\UserInfoController::class => true,
                \SetCMS\Module\User\Controller\UserPublicDoRegistrationController::class => false,
                \SetCMS\Module\User\Controller\UserPublicLogoutController::class => true,
                \SetCMS\Module\User\Controller\UserPublicLoginController::class => false,
                \SetCMS\Module\User\Controller\UserPublicDoLoginController::class => false,
                \SetCMS\Module\User\Controller\UserPublicRestoreController::class => false,
                \SetCMS\Module\User\Controller\UserPublicDoRestoreController::class => false,
            ],
        ],
        UserRoleEnum::ADMIN->toString() => [
            'scope' => [
                //page
                \SetCMS\Module\Page\Controller\PagePrivateNewController::class => true,
                \SetCMS\Module\Page\Controller\PagePrivateCreateController::class => true,
                //post
                \SetCMS\Module\Post\Controller\PostPrivateNewController::class => true,
                // user
                \SetCMS\Module\User\Controller\UserPrivateIndexController::class => true,
                \SetCMS\Module\User\Controller\UserPrivateEditController::class => true,
                \SetCMS\Module\User\Controller\UserPrivateUpdateController::class => true,
                \SetCMS\Module\User\Controller\UserPrivateReadController::class => true,
                // block
                \SetCMS\Module\Block\Controller\BlockPrivateIndexController::class => true,
                \SetCMS\Module\Block\Controller\BlockPrivateEditController::class => true,
                \SetCMS\Module\Block\Controller\BlockPrivateSaveController::class => true,
                \SetCMS\Module\Block\Controller\BlockPrivateReadController::class => true,
                \SetCMS\Module\Block\Controller\BlockPrivateCreateController::class => true,
                \SetCMS\Module\Block\Controller\BlockPrivateUpdateController::class => true,
                \SetCMS\Module\Block\Controller\BlockPublicSectionController::class => true,
                //
                \SetCMS\Module\Configuration\Controller\ConfigurationPublicAdminMenuController::class => true,
                \SetCMS\Module\Configuration\Controller\ConfigurationPublicMainController::class => true,
                //
                \SetCMS\Module\Menu\Controller\MenuPrivateIndexController::class => true,
                \SetCMS\Module\Menu\Controller\MenuPrivateEditController::class => true,
                \SetCMS\Module\Menu\Controller\MenuPrivateCreateController::class => true,
                \SetCMS\Module\Menu\Controller\MenuPrivateNewController::class => true,
                \SetCMS\Module\Menu\Controller\MenuPrivateUpdateController::class => true,
                \SetCMS\Module\Menu\Controller\MenuPublicReadByContextController::class => true,
            ],
        ],
    ],
];

foreach (glob(__DIR__ . '/acl/*.php') as $file) {
    require_once $file;
}

return $acl;
