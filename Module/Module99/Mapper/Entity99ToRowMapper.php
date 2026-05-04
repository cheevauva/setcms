<?php

declare(strict_types=1);

namespace Module\Module99\Mapper;

class Entity99ToRowMapper extends \UUA\Mapper
{

    use \SetCMS\Mapper\MapperEntityToRowTrait;
    use \SetCMS\Mapper\MapperEntityToRowBasicTrait;
    use \Module\Module99\Traits\Entity99CallTrait;

    #[\Override]
    public function serve(): void
    {
        $this->mappingDefault($this->entity99);
        $this->mappingBasic($this->entity99);
        $this->row['field99'] = $this->entity99->field99;
    }
}
