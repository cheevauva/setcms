<?php

declare(strict_types=1);

namespace SetCMS\Record\Mapper;

use SetCMS\Record\Record;

abstract class RecordFromRowMapper extends \SetCMS\Mapper\MapperFromRow
{

    protected function id(Record $record): void
    {
        $record->id = $this->int('id');
    }
}
