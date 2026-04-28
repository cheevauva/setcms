<?php

declare(strict_types=1);

namespace Module\Module01\Mapper;

class Entity01ToRowMapper extends \UUA\Mapper
{

    use \SetCMS\Mapper\MapperEntityToRowTrait;
    use \Module\Module01\Traits\Entity01CallTrait;

    #[\Override]
    public function serve(): void
    {
        $this->mappingDefault($this->entity01);
        $this->row['field01'] = $this->entity01->field01;
    }
}
