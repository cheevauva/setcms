<?php

declare(strict_types=1);

namespace SetCMS\Module\User\Traits;

use SetCMS\Module\User\Entity\UserEntity;

trait UserCurrentTrait
{

    use \SetCMS\Traits\ValidationTrait;

    private bool $_validationStateCurrentUser = false;

    protected function currentUser(): UserEntity
    {
        if (!$this->_validationStateCurrentUser) {
            UserEntity::as($this->validation($this->ctx())->object('currentUser')->notEmpty()->notQuiet()->val());

            $this->_validationStateCurrentUser = true;
        }

        return UserEntity::as($this->ctx()['currentUser']);
    }

    /**
     * @return array<string, mixed>
     */
    abstract protected function ctx(): array;
}
