<?php

declare(strict_types=1);

namespace Module\Module01\Mapper;

class Entity01ToRowMapper extends \SetCMS\Entity\Mapper\EntityToRowMapper
{

    use \Module\Module01\Traits\Entity01CallTrait;

    #[\Override]
    public function serve(): void
    {
        $this->id($this->entity01);
        $this->row['field01'] = $this->entity01->field01;
    }
}
