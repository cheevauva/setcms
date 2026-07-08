<?php

declare(strict_types=1);

namespace Module\RAD99\Mapper;

class RAD99ToRowMapper extends \Module\Basic\Mapper\BasicEntityToRowMapper
{

    use \Module\RAD99\Traits\RAD99CallTrait;

    #[\Override]
    public function serve(): void
    {
        $this->id($this->rad99);
        $this->basic($this->rad99);
        $this->row['field99'] = $this->rad99->field99;
    }
}
