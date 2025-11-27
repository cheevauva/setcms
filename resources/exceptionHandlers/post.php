<?php

declare(strict_types=1);

$exceptionHandlers[Module\Post\Exception\PostNotFoundException::class] = SetCMS\View\ViewNotFound::class;
