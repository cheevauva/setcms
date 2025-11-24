<?php

declare(strict_types=1);

namespace Module\Page\DAO;

use SetCMS\DAO\EntityRetrieveManyDAO;
use SetCMS\Database\DatabaseQueryBuilder;
use Module\Page\Mapper\PageFromRowMapper;
use Module\Page\Entity\PageEntity;

/**
 * @extends EntityRetrieveManyDAO<PageEntity, PageFromRowMapper>
 */
class PageRetrieveManyByCriteriaDAO extends EntityRetrieveManyDAO
{

    use PageCommonDAO;

    protected string $clsMapper = PageFromRowMapper::class;
    public string $slug;

    #[\Override]
    protected function createQuery(): DatabaseQueryBuilder
    {
        if (isset($this->slug)) {
            $this->criteria['slug'] = $this->slug;
        }

        return parent::createQuery();
    }
}
