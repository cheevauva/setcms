<?php

declare(strict_types=1);

namespace Module\UserResetToken\DAO;

use Module\UserResetToken\Exception\UserResetTokenNotFoundException;
use Module\UserResetToken\Entity\UserResetTokenEntity;
use SetCMS\UUID;

class UserResetTokenRetrieveManyByCriteriaDAO extends \SetCMS\Common\DAO\EntityRetrieveManyByCriteriaDAO
{

    use UserResetTokenCommonDAO;

    public ?UserResetTokenEntity $userResetToken = null;

    /**
     * @var UserResetTokenEntity[]
     */
    public array $userResetTokens;
    public UUID $userId;

    #[\Override]
    protected function notFoundExcecption(): \Throwable
    {
        return new UserResetTokenNotFoundException();
    }

    #[\Override]
    public function serve(): void
    {
        if (isset($this->userId)) {
            $this->criteria['user_id'] = $this->userId->uuid;
        }

        parent::serve();

        $this->userResetToken = $this->first ? UserResetTokenEntity::as($this->first) : null;
        $this->userResetTokens = UserResetTokenEntity::manyAs($this->entities);
    }
}
