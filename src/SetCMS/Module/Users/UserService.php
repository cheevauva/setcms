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
        if (!$model->isValid()) {
            return;
        }

        try {
            $model->entity($this->dao()->getByUsernameAndPassword($model->username, $model->password));
        } catch (UserException $ex) {
            $model->addMessage($ex->getMessage(), 'username');
        }
    }

    public function registation(UserModelRegistration $model): void
    {
        if (!$model->isValid()) {
            return;
        }

        try {
            $this->dao()->getByUsername($model->username);
            $model->addMessage('Пользователь уже существует', 'username');
        } catch (UserException $ex) {
            $this->dao()->save($model->entity($this->newEntity()));
        }
    }

    protected function newEntity(): User
    {
        return new User;
    }

}
