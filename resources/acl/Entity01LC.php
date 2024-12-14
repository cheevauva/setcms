<?php

declare(strict_types=1);

use SetCMS\Module\User\Enum\UserRoleEnum;

$acl['rules'][UserRoleEnum::ADMIN->toString()]['scope'][\SetCMS\Module\Module01\Scope\Module01PrivateIndexScope::class] = true;
$acl['rules'][UserRoleEnum::ADMIN->toString()]['scope'][\SetCMS\Module\Module01\Scope\Module01PrivateEditScope::class] = true;
$acl['rules'][UserRoleEnum::ADMIN->toString()]['scope'][\SetCMS\Module\Module01\Scope\Module01PrivateReadScope::class] = true;
$acl['rules'][UserRoleEnum::ADMIN->toString()]['scope'][\SetCMS\Module\Module01\Scope\Module01PrivateUpdateScope::class] = true;
$acl['rules'][UserRoleEnum::ADMIN->toString()]['scope'][\SetCMS\Module\Module01\Scope\Module01PrivateCreateScope::class] = true;
