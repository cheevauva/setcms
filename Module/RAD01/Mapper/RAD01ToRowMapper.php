<?php

declare(strict_types=1);

namespace Module\RAD01\Mapper;

class RAD01ToRowMapper extends \SetCMS\Entity\Mapper\EntityToRowMapper
{

    use \Module\RAD01\Traits\RAD01CallTrait;

    #[\Override]
    public function serve(): void
    {
        $this->id($this->rad01);
        $this->row['field01'] = $this->rad01->field01;
    }
}
