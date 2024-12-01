<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\Exception;

use SetCMS\Application\Contract\ContractNotFound;

class PageNotFoundException extends PageException implements ContractNotFound
{

    public function label(): string
    {
        return 'setcms.page.notfound';
    }

}
