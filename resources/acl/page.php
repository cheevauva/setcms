<?php

declare(strict_types=1);

use SetCMS\Module\User\Enum\UserRoleEnum;

$acl['rules'][UserRoleEnum::ADMIN->toString()]['scope'][\SetCMS\Module\Page\Controller\PagePrivateIndexController::class] = true;
$acl['rules'][UserRoleEnum::ADMIN->toString()]['scope'][\SetCMS\Module\Page\Controller\PagePrivateCreateController::class] = true;
$acl['rules'][UserRoleEnum::ADMIN->toString()]['scope'][\SetCMS\Module\Page\Controller\PagePrivateUpdateController::class] = true;
$acl['rules'][UserRoleEnum::ADMIN->toString()]['scope'][\SetCMS\Module\Page\Controller\PagePrivateEditController::class] = true;
$acl['rules'][UserRoleEnum::ADMIN->toString()]['scope'][\SetCMS\Module\Page\Controller\PagePrivateReadController::class] = true;
