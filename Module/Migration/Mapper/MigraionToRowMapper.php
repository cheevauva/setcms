<?php

declare(strict_types=1);

namespace Module\Migration\Mapper;

class MigraionToRowMapper extends \SetCMS\Entity\Mapper\EntityToRowMapper
{

    use \Module\Migration\Traits\MigrationCallTrait;

    #[\Override]
    public function serve(): void
    {
        $this->row['version'] = $this->migration->version;
        $this->row['executed_at'] = $this->migration->executedAt->format('Y-m-d H:i:s');
        $this->row['execution_time'] = $this->migration->executionTime;
    }
}
