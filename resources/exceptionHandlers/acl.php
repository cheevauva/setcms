<?php

declare(strict_types=1);

$exceptionHandlers[\Module\ACL\Exception\ACLNotAllowException::class] = SetCMS\View\ViewForbidden::class;

