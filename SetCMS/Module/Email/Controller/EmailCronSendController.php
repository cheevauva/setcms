<?php

declare(strict_types=1);

namespace SetCMS\Module\Email\Controller;

class EmailCronSendController extends \SetCMS\Controller
{
    #[\Override]
    public function serve(): void
    {
        throw new \Exception('Ошибка');
    }
}
