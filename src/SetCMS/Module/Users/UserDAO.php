<?php

namespace SetCMS\Module\Users;

use SetCMS\Module\Users\UserDatabase;
use SetCMS\Module\Ordinary\OrdinaryDAO;
use SetCMS\Module\Users\User;

class UserDAO extends OrdinaryDAO
{

    private UserDatabase $db;

    public function __construct(UserDatabase $db)
    {
        $this->db = $db;
    }

    protected function entity2record(\SetCMS\Module\Ordinary\OrdinaryEntity $entity): array
    {
        return $this->ordinaryEntity2RecordBind($entity, []);
    }

    protected function getException(): \Exception
    {
        return new UserException;
    }

    protected function getTableName(): string
    {
        return 'users';
    }

    protected function record2entity(array $row): User
    {
        $user = new User();
        $user->username = $row['username'];
        $user->password = $row['password'];

        return $this->ordinaryRecord2EntityBind($user, $row);
    }

    public function getDatabase(): UserDatabase
    {
        return $this->db;
    }

}
