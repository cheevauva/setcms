<?php

declare(strict_types=1);

$jobs[\SetCMS\Module\Email\Controller\EmailCronSendController::class] = [
    'EmailSendJob',
    'Работа по отправке электронных писем',
];
