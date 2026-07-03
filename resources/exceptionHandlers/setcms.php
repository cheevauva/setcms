<?php

declare(strict_types=1);

$exceptionHandlers[SetCMS\Router\Exception\RouterNotFoundException::class] = SetCMS\View\ViewNotFound::class;
$exceptionHandlers[SetCMS\Controller\Exception\ControllerEmptyResponseException::class] = SetCMS\View\ViewNoContent::class;
$exceptionHandlers[SetCMS\UUID\Exception\UUIDInvalidException::class] = SetCMS\View\ViewBadRequest::class;
