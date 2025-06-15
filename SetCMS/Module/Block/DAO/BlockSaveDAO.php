<?php

declare(strict_types=1);

namespace SetCMS\Module\Block\DAO;

use SetCMS\Common\DAO\EntitySaveDAO;
use SetCMS\Module\Block\BlockEntity;

class BlockSaveDAO extends EntitySaveDAO
{

    use BlockGenericDAO;

    public BlockEntity $block;

    public function serve(): void
    {
        $this->entity = $this->block;

        parent::serve();
    }
}
