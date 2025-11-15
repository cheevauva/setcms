<?php

declare(strict_types=1);

namespace Module\UserResetToken\DAO;

use Module\UserResetToken\UserResetTokenConstants;
use Module\UserResetToken\Mapper\UserResetTokenMapper;

trait UserResetTokenCommonDAO
{

    use \SetCMS\Traits\DatabaseMainTrait;

    #[\Override]
    protected function mapper(): UserResetTokenMapper
    {
        return UserResetTokenMapper::new($this->container);
    }

    #[\Override]
    protected function table(): string
    {
        return UserResetTokenConstants::TABLE_NAME;
    }
}
