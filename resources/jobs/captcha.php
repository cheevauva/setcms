<?php

declare(strict_types=1);

$jobs[\Module\Captcha\Controller\CaptchaCronClearExpiredController::class] = [
    'CaptchaClearExpiredJob',
    'Работа по очистке устаревших записей каптчи'
];
