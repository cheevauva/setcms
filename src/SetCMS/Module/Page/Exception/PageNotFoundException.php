<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\Exception;

use SetCMS\Contract\NotFound;

class PageNotFoundException extends PageException implements NotFound
{

    public function label(): string
    {
        return 'setcms.page.notfound';
    }

}
