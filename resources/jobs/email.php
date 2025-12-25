<?php

declare(strict_types=1);

$jobs[Module\Email\Controller\EmailCronSendController::class] = [
    'EmailSendJob',
    'Работа по отправке электронных писем',
];
