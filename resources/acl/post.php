<?php

declare(strict_types=1);

use SetCMS\Module\User\Enum\UserRoleEnum;

$acl['rules'][UserRoleEnum::ADMIN->toString()]['scope'][\SetCMS\Module\Post\Scope\PostPrivateIndexScope::class] = true;
$acl['rules'][UserRoleEnum::ADMIN->toString()]['scope'][\SetCMS\Module\Post\Scope\PostPrivateSaveScope::class] = true;
$acl['rules'][UserRoleEnum::ADMIN->toString()]['scope'][\SetCMS\Module\Post\Scope\PostPrivateEditScope::class] = true;
$acl['rules'][UserRoleEnum::ADMIN->toString()]['scope'][\SetCMS\Module\Post\Scope\PostPrivateReadScope::class] = true;
$acl['rules'][UserRoleEnum::ADMIN->toString()]['scope'][\SetCMS\Module\Post\Scope\PostPrivateUpdateScope::class] = true;
$acl['rules'][UserRoleEnum::ADMIN->toString()]['scope'][\SetCMS\Module\Post\Scope\PostPrivateCreateScope::class] = true;
$acl['rules'][UserRoleEnum::ADMIN->toString()]['scope'][\SetCMS\Module\Post\Scope\PostPublicIndexScope::class] = true;
