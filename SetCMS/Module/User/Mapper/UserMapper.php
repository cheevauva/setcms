<?php

declare(strict_types=1);

namespace SetCMS\Module\User\Mapper;

use SetCMS\Module\User\Entity\UserEntity;
use SetCMS\Module\User\Enum\UserRoleEnum;
use SetCMS\Module\User\Exception\UserMapperException;
use SetCMS\Module\User\VO\UserResetPasswordTicketVO;
use SetCMS\UUID;

class UserMapper extends \SetCMS\Common\Mapper\EntityMapper
{

    #[\Override]
    protected function entity2row(): void
    {
        parent::entity2row();

        $entity = UserEntity::as($this->entity);

        $this->row['username'] = $entity->username;
        $this->row['password'] = $entity->password;
        $this->row['role'] = $entity->role->value;
        $this->row['email'] = $entity->email;
        $this->row['extra'] = json_encode($this->extra2row(), JSON_UNESCAPED_UNICODE);
    }

    /**
     * @return array<string|mixed>
     */
    protected function extra2row(): array
    {
        $user = UserEntity::as($this->entity);

        $extra = [];

        if ($user->resetPasswordTicket) {
            $extra['resetPasswordTicket'] = [
                'code' => $user->resetPasswordTicket->code,
                'ctime' => $user->resetPasswordTicket->dateCreated->format('Y-m-d H:i:s'),
                'userd' => intval($user->resetPasswordTicket->used),
            ];
        }

        return $extra;
    }

    protected function extra4row(UserEntity $user): void
    {
        $extra = json_decode($this->row['extra'] ?? '{}');

        if (!empty($extra['resetPasswordTicket'])) {
            $resetPasswordTicket = new UserResetPasswordTicketVO();
            $resetPasswordTicket->code = new UUID($extra['resetPasswordTicket']['code'] ?? throw new UserMapperException('row.resetPasswordTicket.code not defined'));
            $resetPasswordTicket->dateCreated = new \DateTimeImmutable($extra['resetPasswordTicket']['ctime'] ?? throw new UserMapperException('row.resetPasswordTicket.ctime not defined'));
            $resetPasswordTicket->used = boolval($extra['resetPasswordTicket']['used'] ?? false);

            $user->resetPasswordTicket = $resetPasswordTicket;
        }
    }

    #[\Override]
    protected function entity4row(): void
    {
        parent::entity4row();

        $entity = UserEntity::as($this->entity);
        $entity->username = strval($this->row['username'] ?? throw new UserMapperException('row.username not defined'));
        $entity->password = strval($this->row['password'] ?? throw new UserMapperException('row.password not defined'));
        $entity->email = strval($this->row['email'] ?? throw new UserMapperException('row.email not defined'));
        $entity->role = UserRoleEnum::from(strval($this->row['role'] ?? throw new UserMapperException('row.role not defined')));
    }
}
