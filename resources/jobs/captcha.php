<?php

declare(strict_types=1);

$jobs[\SetCMS\Module\Captcha\Controller\CaptchaCronClearExpiredController::class] = [
    'CaptchaClearExpiredJob',
    'Работа по очистке устаревших записей каптчи'
];
