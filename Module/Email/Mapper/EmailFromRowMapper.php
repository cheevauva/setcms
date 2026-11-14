<?php

declare(strict_types=1);

namespace Module\Email\Mapper;

use Module\Email\Entity\EmailEntity;
use Module\Email\Enum\EmailStatusEnum;
use SetCMS\Entity\Mapper\EntityFromRowMapper;

/**
 * @extends EntityFromRowMapper<EmailEntity>
 */
class EmailFromRowMapper extends EntityFromRowMapper
{

    #[\Override]
    protected function run(): void
    {
        $entity = $this->entity = new EmailEntity();
        $entity->subject = $this->string('subject');
        $entity->from = $this->string('from_addr');
        $entity->to = $this->string('to_addr');
        $entity->body = $this->string('body');
        $entity->dateSent = $this->dateTimeOrNull('date_sent');
        $entity->status = EmailStatusEnum::from($this->string('status'));
        
        parent::run();
    }

}
