<?php

declare(strict_types=1);

namespace SetCMS\Module\User\Servant;

use SetCMS\Entity\Exception\EntityNotFoundException;
use SetCMS\Module\User\UserEntity;
use SetCMS\Module\User\DAO\UserEntitySaveDAO;
use SetCMS\Module\User\DAO\UserEntityRetrieveByUsernameDAO;
use SetCMS\Module\User\Event\UserRegistrationEvent;
use SetCMS\Module\User\UserRoleEnum;

class UserRegistrationServant implements \SetCMS\ServantInterface
{

    use \SetCMS\DITrait;
    use \SetCMS\EventDispatcherTrait;

    public string $username;
    public string $password;
    public ?UserEntity $user = null;

    public function serve(): void
    {
        try {
            $retrieveByUsername = UserEntityRetrieveByUsernameDAO::make($this->factory());
            $retrieveByUsername->username = $this->username;
            $retrieveByUsername->throwExceptions = true;
            $retrieveByUsername->serve();

            throw new \DomainException('Такой пользователь уже существует');
        } catch (EntityNotFoundException $ex) {
            $user = new UserEntity;
            $user->username = $this->username;
            $user->password = $this->password;
            $user->role = UserRoleEnum::USER;

            $saveUser = UserEntitySaveDAO::make($this->factory());
            $saveUser->entity = $user;
            $saveUser->serve();

            $event = new UserRegistrationEvent;
            $event->user = $user;
            $event->dispatch($this->eventDispatcher());

            $this->user = $user;
        }
    }

}
