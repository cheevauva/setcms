<?php

declare(strict_types=1);

namespace SetCMS\Module\Block\DAO;

use Doctrine\DBAL\Query\QueryBuilder;

class BlockRetrieveManyBySectionDAO extends BlockRetrieveManyDAO
{

    public string $section;

    protected function createQuery(): QueryBuilder
    {
        $qb = parent::createQuery();
        $qb->andWhere('section = :section');
        $qb->setParameters([
            'section' => $this->section,
            'deleted' => 0,
        ]);

        return $qb;
    }

}
