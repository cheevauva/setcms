<?php

declare(strict_types=1);

namespace Module\Module99\Mapper;

class Entity99ToRowMapper extends \SetCMS\Entity\Mapper\EntityBasicToRowMapper
{

    use \Module\Module99\Traits\Entity99CallTrait;

    #[\Override]
    public function serve(): void
    {
        $this->id($this->entity99);
        $this->basic($this->entity99);
        $this->row['field99'] = $this->entity99->field99;
    }
}
