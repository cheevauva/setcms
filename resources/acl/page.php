<?php

declare(strict_types=1);

use SetCMS\Module\User\Enum\UserRoleEnum;

$acl['rules'][UserRoleEnum::ADMIN->toString()]['scope'][\SetCMS\Module\Page\Scope\PagePrivateIndexScope::class] = true;
$acl['rules'][UserRoleEnum::ADMIN->toString()]['scope'][\SetCMS\Module\Page\Scope\PagePrivateCreateScope::class] = true;
$acl['rules'][UserRoleEnum::ADMIN->toString()]['scope'][\SetCMS\Module\Page\Scope\PagePrivateUpdateScope::class] = true;
$acl['rules'][UserRoleEnum::ADMIN->toString()]['scope'][\SetCMS\Module\Page\Scope\PagePrivateEditScope::class] = true;
$acl['rules'][UserRoleEnum::ADMIN->toString()]['scope'][\SetCMS\Module\Page\Scope\PagePrivateReadScope::class] = true;
