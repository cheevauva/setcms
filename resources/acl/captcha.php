<?php

declare(strict_types=1);

use Module\User\UserRoleConstants;

$acl['rules'][UserRoleConstants::GUEST]['routes']['CaptchaGenerate'] = true;
$acl['rules'][UserRoleConstants::GUEST]['routes']['CaptchaSolve'] = true;
