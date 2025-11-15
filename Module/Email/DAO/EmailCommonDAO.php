<?php

declare(strict_types=1);

namespace Module\Email\DAO;

use Module\Email\Mapper\EmailMapper;
use Module\Email\EmailConstrants;

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
