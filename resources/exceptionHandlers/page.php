<?php

declare(strict_types=1);

$exceptionHandlers[\Module\Page\Exception\PageNotFoundException::class] = SetCMS\View\ViewNotFound::class;
