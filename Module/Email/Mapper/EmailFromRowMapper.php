<?php

declare(strict_types=1);

namespace Module\Email\Mapper;

use Module\Email\Entity\EmailEntity;
use Module\Email\Enum\EmailStatusEnum;
use Module\Email\Exception\EmailMapperNotFoundKeyInRowException;

class EmailFromRowMapper extends \SetCMS\Entity\Mapper\EntityFromRowMapper
{

    public protected(set) EmailEntity $email;

    #[\Override]
    public function serve(): void
    {
        $this->email = new EmailEntity();
        $this->email->subject = $this->string('subject');
        $this->email->from = $this->string('from_addr');
        $this->email->to = $this->string('to_addr');
        $this->email->body = $this->string('body');
        $this->email->dateSent = $this->dateTimeOrNull('date_sent');
        $this->email->status = EmailStatusEnum::from($this->string('status'));
        $this->id($this->email);
    }

    #[\Override]
    protected function notFoundKeyInRowException(string $key): EmailMapperNotFoundKeyInRowException
    {
        throw new EmailMapperNotFoundKeyInRowException($key);
    }
}
