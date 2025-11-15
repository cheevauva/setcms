<?php

declare(strict_types=1);

namespace Module\UserResetToken\DAO;

use Module\UserResetToken\Entity\UserResetTokenEntity;

class UserResetTokenSaveDAO extends \SetCMS\DAO\EntitySaveDAO
{

    use UserResetTokenCommonDAO;

    public UserResetTokenEntity $userResetToken;

    #[\Override]
    public function serve(): void
    {
        $this->entity = $this->userResetToken;

        parent::serve();
    }
}
