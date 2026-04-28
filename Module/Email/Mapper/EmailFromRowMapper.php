<?php

declare(strict_types=1);

namespace Module\Email\Mapper;

use Module\Email\Entity\EmailEntity;
use Module\Email\Enum\EmailStatusEnum;

class EmailFromRowMapper extends \UUA\Mapper
{

    use \SetCMS\Mapper\MapperEntityFromRowTrait;

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
        $this->mappingDefault($this->email);
    }

    #[\Override]
    protected function notFoundKeyInRowException(string $key): \Throwable
    {
        throw new \Exception($key);
    }
}
