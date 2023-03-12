<?php

declare(strict_types=1);

namespace SetCMS\Module\Block\DAO;

use SetCMS\Entity\DAO\EntityRetrieveByIdDAO;
use SetCMS\Module\Block\BlockEntity;

class BlockRetrieveByIdDAO extends EntityRetrieveByIdDAO
{

    use BlockGenericDAO;

    public BlockEntity $block;

    public function serve(): void
    {
        parent::serve();

        $this->block = $this->entity;
    }

}
