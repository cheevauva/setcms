<?php

declare(strict_types=1);

namespace Module\Module01\Mapper;

class Entity01ToRowMapper extends \UUA\Mapper
{

    use \SetCMS\Mapper\EntityToRowMapperTrait;
    use \Module\Module01\Traits\Entity01CallTrait;

    #[\Override]
    public function serve(): void
    {
        $this->row['field01'] = $this->entity01->field01;

        $this->map($this->entity01);
    }
}
