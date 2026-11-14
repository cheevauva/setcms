<?php

declare(strict_types=1);

namespace Module\Email\Mapper;

use Module\Email\Entity\EmailEntity;

class EmailToRowMapper extends \SetCMS\Entity\Mapper\EntityToRowMapper
{

    #[\Override]
    protected function run(): void
    {
        $entity = EmailEntity::as($this->entity);

        $this->row['subject'] = $entity->subject;
        $this->row['status'] = $entity->status->value;
        $this->row['from_addr'] = $entity->from;
        $this->row['to_addr'] = $entity->to;
        $this->row['body'] = $entity->body;
        $this->row['date_sent'] = $entity->dateSent?->format('Y-m-d H:i:s');

        parent::run();
    }
}
