<?php

declare(strict_types=1);

$wrappers[\SetCMS\Controller\ControllerViaPSR7::class] = [
    Module\ACL\Wrapper\ACLControllerWrapper::class
];
$wrappers[SetCMS\View\ViewHtml::class] = [
    \Module\ACL\Wrapper\ACLViewCanWrapper::class,
];

