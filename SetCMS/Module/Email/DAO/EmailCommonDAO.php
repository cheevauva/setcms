<?php

declare(strict_types=1);

namespace SetCMS\Module\Email\DAO;

use SetCMS\Module\Email\Mapper\EmailMapper;
use SetCMS\Module\Email\EmailConstrants;

trait EmailCommonDAO
{

    use \SetCMS\Traits\DatabaseMainTrait;

    protected function mapper(): EmailMapper
    {
        return EmailMapper::new($this->container);
    }

    protected function table(): string
    {
        return EmailConstrants::TABLE_NAME;
    }
}
