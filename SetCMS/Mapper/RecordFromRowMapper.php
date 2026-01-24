<?php

declare(strict_types=1);

namespace SetCMS\Mapper;

use UUA\Mapper;
use SetCMS\Record\Record;
use SetCMS\Exception\RecordMapperNotFoundKeyInRowException;

/**
 * @template T of Record
 */
class RecordFromRowMapper extends Mapper
{

    /**
     * @var T
     */
    public protected(set) Record $record;

    /**
     * @var array<string, mixed>
     */
    public array $row;

    #[\Override]
    public function serve(): void
    {
        $record = Record::as($this->record);
        $record->id = intval($this->row['id'] ?? throw new RecordMapperNotFoundKeyInRowException('id'));
    }
}
