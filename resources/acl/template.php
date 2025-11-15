<?php

declare(strict_types=1);

use Module\User\UserRoleConstants;

$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminTemplateIndex'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminTemplateNew'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminTemplateEdit'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminTemplateRead'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminTemplateUpdate'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminTemplateCreate'] = true;
