<?php

declare(strict_types=1);

namespace Module\Email\Mapper;

use SetCMS\Common\Mapper\EntityMapper;
use Module\Email\Entity\EmailEntity;
use Module\Email\Enum\EmailStatusEnum;
use Module\Email\Exception\EmailMapperException;

class EmailMapper extends EntityMapper
{

    #[\Override]
    protected function entity2row(): void
    {
        parent::entity2row();

        $email = EmailEntity::as($this->entity);

        $this->row['subject'] = $email->subject;
        $this->row['status'] = $email->status->value;
        $this->row['from_addr'] = $email->from;
        $this->row['to_addr'] = $email->to;
        $this->row['body'] = $email->body;
        $this->row['date_sent'] = $email->dateSent?->format('Y-m-d H:i:s');
    }

    #[\Override]
    protected function entity4row(): void
    {
        parent::entity4row();

        $entity = EmailEntity::as($this->entity);
        $entity->subject = strval($this->row['subject'] ?? throw new EmailMapperException('row.subject обязателен'));
        $entity->from = strval($this->row['from_addr'] ?? throw new EmailMapperException('row.from_addr обязателен'));
        $entity->to = strval($this->row['to_addr'] ?? throw new EmailMapperException('row.to_addr обязателен'));
        $entity->body = strval($this->row['body'] ?? throw new EmailMapperException('row.body обязателен'));
        $entity->dateSent = !empty($this->row['date_sent']) ? new \DateTimeImmutable($this->row['date_sent']) : null;
        $entity->status = EmailStatusEnum::from($this->row['status'] ?? throw new EmailMapperException('row.status обязателен'));
    }
}
