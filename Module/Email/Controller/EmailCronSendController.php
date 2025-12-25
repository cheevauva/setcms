<?php

declare(strict_types=1);

namespace Module\Email\Controller;

class EmailCronSendController extends \SetCMS\Controller\Controller
{

    #[\Override]
    public function serve(): void
    {
        throw new \Exception('Ошибка');
    }

    #[\Override]
    protected function process(): void
    {
        
    }
}
