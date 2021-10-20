<?php

namespace SetCMS\Module\Users;

use SetCMS\Module\Ordinary\OrdinaryService;
use SetCMS\Module\Users\UserDAO;
use SetCMS\Module\Users\User;
use SetCMS\Module\Users\UserException;
use SetCMS\Module\Users\UserModel\UserModelLogin;
use SetCMS\Module\Users\UserModel\UserModelRegistration;

class UserService extends OrdinaryService
{

    private UserDAO $dao;

    public function __construct(UserDAO $userDAO)
    {
        $this->dao = $userDAO;
    }

    protected function dao(): UserDAO
    {
        return $this->dao;
    }

    public function login(UserModelLogin $model): void
    {
        try {
            $blankUser = $model->entity($this->entity());
            $user = $this->getByUsernameAndPassword($model->username, $model->password);
            $model->entity($user);
        } catch (UserException $ex) {
            $model->addMessage($ex->getMessage(), 'username');
        }
    }

    public function getById(string $id): User
    {
        return $this->dao()->get($id);
    }

    public function createUser(string $username, string $password): User
    {
        $user = $this->entity();
        $user->username = $username;
        $user->password(User::hashPassword($password));
        
        $this->dao()->save($user);
        
        return $user;
    }

    public function registation(UserModelRegistration $model): void
    {
        try {
            $this->dao()->getByUsername($model->username);
            $model->addMessage('Пользователь уже существует', 'username');
        } catch (UserException $ex) {
            $this->dao()->save($model->entity($this->entity()));
        }
    }

    public function getByUsernameAndPassword(string $username, string $password): User
    {
        return $this->dao()->getByUsernameAndPassword($username, User::hashPassword($password));
    }

    public function entity(): User
    {
        return new User;
    }

}
