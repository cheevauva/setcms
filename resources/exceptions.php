<?php

declare(strict_types=1);

use SetCMS\View\ViewInternalError;
use SetCMS\View\ViewNotFound;

$ex[SetCMS\Module\Dynamic\Exception\DynamicClassNotFoundException::class] = ViewNotFound::class;
$ex[SetCMS\Module\Dynamic\Exception\DynamicExpectedAttributeNotDefinedException::class] = ViewInternalError::class;
