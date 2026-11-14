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
        $email = $this->entity = new EmailEntity();
        $email->subject = $this->string('subject');
        $email->from = $this->string('from_addr');
        $email->to = $this->string('to_addr');
        $email->body = $this->string('body');
        $email->dateSent = $this->dateTimeOrNull('date_sent');
        $email->status = EmailStatusEnum::from($this->string('status'));
        
        parent::run();
    }

}
