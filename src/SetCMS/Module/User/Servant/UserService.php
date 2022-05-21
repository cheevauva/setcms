<?php

namespace SetCMS\Module\Users;

use SetCMS\Module\Ordinary\OrdinaryService;
use SetCMS\Module\Users\UserDAO;
use SetCMS\Module\Users\User;
use SetCMS\Module\Users\UserException;
use SetCMS\Module\Users\UserModel\UserRegistrationForm;
use SetCMS\EventDispatcher;
use SetCMS\Module\Users\UserEvent\UserAfterRegistrationEvent;
use SetCMS\HttpStatusCode\NotFound;

class UserService extends OrdinaryService
{

    private const USER_GUEST_ID = '-1';
    private const USER_MAIN_ADMIN_ID = '1';

    private UserDAO $dao;
    private EventDispatcher $eventDispatcher;

    public function __construct(UserDAO $userDAO, EventDispatcher $eventDispatcher)
    {
        $this->dao = $userDAO;
        $this->eventDispatcher = $eventDispatcher;
    }

    protected function dao(): UserDAO
    {
        return $this->dao;
    }

    public function getById(string $id): User
    {
        return $this->dao()->get($id);
    }

 
    public function createUser(string $username, string $password): User
    {
        $user = $this->entity();
        $user->username = $username;
        $user->password(User::passwordHash($password));

        $this->dao()->save($user);

        return $user;
    }

    public function registation(UserRegistrationForm $model): void
    {            $this->captchaService->useSolvedCaptchaById($scope->captcha);
        try {
            $this->dao()->getByUsername($model->username);
            $model->addMessage('Пользователь уже существует', 'username');
        } catch (UserException $ex) {
            $user = $model->entity($this->entity());
            $this->dao()->save($user);

            $this->eventDispatcher->dispatch(new UserAfterRegistrationEvent($user));
        }
    }

    public function authenticate(string $username, string $password): User
    {
        $user = $this->dao()->getByUsername($username);

        if (!$user->isThisYourPassword($password)) {
            throw UserException::passwordInvalid();
        }

        return $user;
    }

    public function getByUsernameAndPassword(string $username, string $password): User
    {
        return $this->dao()->getByUsernameAndPassword($username, User::passwordHash($password));
    }

    public function entity(): User
    {
        return new User;
    }

}
