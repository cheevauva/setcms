<?php

declare(strict_types=1);

$exceptionHandlers[SetCMS\ACL\Exception\ACLNotAllowException::class] = SetCMS\View\ViewForbidden::class;
$exceptionHandlers[SetCMS\Router\Exception\RouterNotFoundException::class] = SetCMS\View\ViewNotFound::class;
$exceptionHandlers[SetCMS\Controller\Exception\ControllerEmptyResponseException::class] = SetCMS\View\ViewNoContent::class;
