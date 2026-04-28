<?php

declare(strict_types=1);

namespace SetCMS\Mapper;

use UUA\Mapper;
use SetCMS\Record\Record;

/**
 * @template T of Record
 */
class MapperRecordToRow extends Mapper
{

    /**
     * @var T
     */
    public Record $record;

    /**
     * @var array<string, mixed>
     */
    public protected(set) array $row;

    #[\Override]
    public function serve(): void
    {
        $record = $this->record;

        $this->row = [];
        $this->row['id'] = $record->id ?? null;
    }
}
