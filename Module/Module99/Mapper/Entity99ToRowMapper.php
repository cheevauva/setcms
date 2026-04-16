<?php

declare(strict_types=1);

namespace Module\Module99\Mapper;

class Entity99ToRowMapper extends \UUA\Mapper
{

    use \SetCMS\Mapper\EntityToRowMapperTrait;
    use \SetCMS\Mapper\EntityToRowBasicMapperTrait;
    use \Module\Module99\Traits\Entity99CallTrait;

    #[\Override]
    public function serve(): void
    {
        $this->row['field99'] = $this->entity99->field99;

        $this->map($this->entity99);
        $this->mapBasic($this->entity99);
    }
}
