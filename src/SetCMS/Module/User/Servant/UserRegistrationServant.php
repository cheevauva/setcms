<?php

declare(strict_types=1);

namespace SetCMS\Module\User\Servant;

use Psr\Container\ContainerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use SetCMS\FactoryInterface;
use SetCMS\Entity\Exception\EntityNotFoundException;
use SetCMS\Module\User\UserEntity;
use SetCMS\Module\User\DAO\UserEntityDbSaveDAO;
use SetCMS\Module\User\DAO\UserEntityDbRetrieveByUsernameDAO;
use SetCMS\Module\User\Event\UserAfterRegistrationEvent;

class UserRegistrationServant implements \SetCMS\ServantInterface
{

    private EventDispatcherInterface $eventDispatcher;
    private FactoryInterface $factory;
    public string $username;
    public string $password;

    public function __construct(FactoryInterface $factory, ContainerInterface $container)
    {
        $this->factory = $factory;
        $this->eventDispatcher = $container->get(EventDispatcherInterface::class);
    }

    public function serve(): void
    {
        try {
            $retrieveByUsername = UserEntityDbRetrieveByUsernameDAO::factory($this->factory);
            $retrieveByUsername->username = $this->username;
            $retrieveByUsername->throwExceptions = true;
            $retrieveByUsername->serve();

            throw new \DomainException('Такой пользователь уже существует');
        } catch (EntityNotFoundException $ex) {
            $user = new UserEntity;
            $user->username = $this->username;
            $user->password = $this->password;

            $save = UserEntityDbSaveDAO::factory($this->factory);
            $save->entity = $user;
            $save->serve();

            (new UserAfterRegistrationEvent($user))->dispatch($this->eventDispatcher);
        }
    }

}
