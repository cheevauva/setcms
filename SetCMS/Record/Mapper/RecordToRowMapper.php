<?php

declare(strict_types=1);

namespace SetCMS\Record\Mapper;

use SetCMS\Record\Record;

abstract class RecordToRowMapper extends \UUA\Mapper
{

    /**
     * @var array<string, mixed>
     */
    public protected(set) array $row = [];

    protected function id(Record $record): void
    {
        $this->row['id'] = $record->id ?? null;
    }
}
