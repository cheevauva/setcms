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
        assert($entity instanceof User);

        return $this->ordinaryEntity2RecordBind($entity, [
            'username' => $entity->username,
            'password' => $entity->password,
        ]);
    }

    protected function getException(): UserException
    {
        return new UserException;
    }

    protected function getTableName(): string
    {
        return 'users';
    }

    protected function record2entity(array $row): User
    {
        $user = new User;
        $user->username = $row['username'];
        $user->password = $row['password'];

        return $this->ordinaryRecord2EntityBind($row, $user);
    }

    public function getByUsername(string $username): User
    {
        $qb = $this->getDatabase()->createQueryBuilder();
        $qb->select('t.*');
        $qb->from($this->getTableName(), 't');
        $qb->andWhere('t.username = :username');
        $qb->setParameters([
            'username' => $username,
        ]);
        $qb->setMaxResults(1);

        $row = $qb->fetchAssociative();

        if (empty($row)) {
            throw $this->getException()::notFound();
        }

        return $this->record2entity($row);
    }

    public function getByUsernameAndPassword(string $username, string $password): User
    {
        $qb = $this->getDatabase()->createQueryBuilder();
        $qb->select('t.*');
        $qb->from($this->getTableName(), 't');
        $qb->andWhere('t.username = :username AND t.password = :password');
        $qb->setParameters([
            'username' => $username,
            'password' => $password,
        ]);
        $qb->setMaxResults(1);

        $row = $qb->fetchAssociative();

        if (empty($row)) {
            throw $this->getException()::loginFail();
        }

        return $this->record2entity($row);
    }

    public function getDatabase(): UserDatabase
    {
        return $this->db;
    }

}
