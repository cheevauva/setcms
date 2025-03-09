<?php

declare(strict_types=1);

use SetCMS\Module\User\Enum\UserRoleEnum;

$acl['rules'][UserRoleEnum::ADMIN->toString()]['scope'][\SetCMS\Module\Post\Scope\PostPrivateIndexController::class] = true;
$acl['rules'][UserRoleEnum::ADMIN->toString()]['scope'][\SetCMS\Module\Post\Scope\PostPrivateSaveScope::class] = true;
$acl['rules'][UserRoleEnum::ADMIN->toString()]['scope'][\SetCMS\Module\Post\Scope\PostPrivateEditController::class] = true;
$acl['rules'][UserRoleEnum::ADMIN->toString()]['scope'][\SetCMS\Module\Post\Scope\PostPrivateReadController::class] = true;
$acl['rules'][UserRoleEnum::ADMIN->toString()]['scope'][\SetCMS\Module\Post\Scope\PostPrivateUpdateController::class] = true;
$acl['rules'][UserRoleEnum::ADMIN->toString()]['scope'][\SetCMS\Module\Post\Scope\PostPrivateCreateController::class] = true;
$acl['rules'][UserRoleEnum::ADMIN->toString()]['scope'][\SetCMS\Module\Post\Scope\PostPublicIndexController::class] = true;
