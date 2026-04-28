<?php

declare(strict_types=1);

namespace Module\Email\Mapper;

class EmailToRowMapper extends \UUA\Mapper
{

    use \Module\Email\Traits\EmailCallTrait;
    use \SetCMS\Mapper\MapperEntityToRowBasicTrait;

    #[\Override]
    public function serve(): void
    {
        $this->mappingDefault($this->email);
        $this->mappingBasic($this->email);
        $this->row['subject'] = $this->email->subject;
        $this->row['status'] = $this->email->status->value;
        $this->row['from_addr'] = $this->email->from;
        $this->row['to_addr'] = $this->email->to;
        $this->row['body'] = $this->email->body;
        $this->row['date_sent'] = $this->email->dateSent?->format('Y-m-d H:i:s');
    }
}
